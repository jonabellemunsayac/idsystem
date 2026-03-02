<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QueryEditorController extends Controller
{
    public function index()
    {
        // Get all tables in the database
        $tables = DB::select('SHOW TABLES');
        $databaseName = env('DB_DATABASE');
        $tableKey = "Tables_in_{$databaseName}";
        
        $tableNames = array_map(function($table) use ($tableKey) {
            return $table->$tableKey;
        }, $tables);

        // Get table details (row counts)
        $tableDetails = [];
        foreach ($tableNames as $tableName) {
            try {
                $count = DB::table($tableName)->count();
                $tableDetails[] = [
                    'name' => $tableName,
                    'rows' => $count
                ];
            } catch (\Exception $e) {
                $tableDetails[] = [
                    'name' => $tableName,
                    'rows' => 'N/A'
                ];
            }
        }

        return view('query-editor.index', [
            'tables' => $tableDetails
        ]);
    }

    public function executeQuery(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $query = trim($request->input('query'));
        
        try {
            // Check if query is a read-only statement
            $queryType = strtoupper(preg_replace('/\s+/', ' ', substr(ltrim($query), 0, 10)));
            
            // List of read-only query types
            $readOnlyTypes = ['SELECT', 'SHOW', 'DESCRIBE', 'EXPLAIN', 'DESC'];
            $isReadOnly = false;
            
            foreach ($readOnlyTypes as $type) {
                if (strpos($queryType, $type) === 0) {
                    $isReadOnly = true;
                    break;
                }
            }
            
            if ($isReadOnly) {
                // Read-only queries
                $results = DB::select($query);
                
                // Convert stdClass objects to arrays for better JSON handling
                $resultsArray = json_decode(json_encode($results), true);
                
                return response()->json([
                    'success' => true,
                    'type' => 'select',
                    'data' => $resultsArray,
                    'count' => count($results),
                    'message' => 'Query executed successfully. ' . count($results) . ' row(s) returned.'
                ]);
            } else {
                // Write queries (INSERT, UPDATE, DELETE, etc.)
                $affectedRows = DB::affectingStatement($query);
                
                return response()->json([
                    'success' => true,
                    'type' => 'write',
                    'affected_rows' => $affectedRows,
                    'message' => 'Query executed successfully. ' . $affectedRows . ' row(s) affected.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getTableStructure(Request $request, $tableName)
    {
        try {
            // Get table columns
            $columns = DB::select("DESCRIBE {$tableName}");
            
            return response()->json([
                'success' => true,
                'table' => $tableName,
                'columns' => $columns
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function previewTable(Request $request, $tableName)
    {
        try {
            $limit = $request->input('limit', 100);
            $results = DB::table($tableName)->limit($limit)->get();
            
            return response()->json([
                'success' => true,
                'table' => $tableName,
                'data' => $results,
                'count' => count($results)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
