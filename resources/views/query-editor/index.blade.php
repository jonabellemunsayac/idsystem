@extends('layouts.app')

@section('title', 'Query Editor - Pasig BMS')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0"><i class="bi bi-terminal me-2"></i>Database Query Editor</h1>
            <p class="text-muted">Execute SQL queries and manage database tables</p>
        </div>
    </div>

    <div class="row">
        <!-- Tables List -->
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-table me-2"></i>Tables</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 600px; overflow-y: auto;">
                        @foreach($tables as $table)
                        <a href="#" class="list-group-item list-group-item-action table-item" 
                           data-table="{{ $table['name'] }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-table me-2"></i>{{ $table['name'] }}</span>
                                <span class="badge bg-secondary">{{ $table['rows'] }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Query Editor and Results -->
        <div class="col-lg-9">
            <!-- Query Editor -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-code-square me-2"></i>SQL Query Editor</h5>
                </div>
                <div class="card-body">
                    <form id="queryForm">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control font-monospace" 
                                      id="queryInput" 
                                      name="query" 
                                      rows="6" 
                                      placeholder="Enter your SQL query here... (e.g., SELECT * FROM residents LIMIT 10)"
                                      style="font-size: 14px;"></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-play-fill me-2"></i>Execute Query
                            </button>
                            <button type="button" class="btn btn-secondary" id="clearBtn">
                                <i class="bi bi-trash me-2"></i>Clear
                            </button>
                            <button type="button" class="btn btn-info" id="formatBtn">
                                <i class="bi bi-magic me-2"></i>Format SQL
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Query Results -->
            <div id="resultsContainer" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-check-circle me-2"></i>Query Results
                            <span id="resultInfo" class="badge bg-light text-dark ms-2"></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="resultsContent" style="overflow-x: auto; max-height: 500px;"></div>
                    </div>
                </div>
            </div>

            <!-- Error Display -->
            <div id="errorContainer" style="display: none;">
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Error</h5>
                    </div>
                    <div class="card-body">
                        <pre id="errorContent" class="text-danger mb-0" style="white-space: pre-wrap;"></pre>
                    </div>
                </div>
            </div>

            <!-- Sample Queries -->
            <div class="card shadow-sm mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-lightbulb me-2"></i>Sample Queries</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action sample-query" 
                           data-query="SELECT * FROM residents LIMIT 10">
                            <i class="bi bi-arrow-return-right me-2"></i>View first 10 residents
                        </a>
                        <a href="#" class="list-group-item list-group-item-action sample-query" 
                           data-query="SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'">
                            <i class="bi bi-arrow-return-right me-2"></i>Count pending appointments
                        </a>
                        <a href="#" class="list-group-item list-group-item-action sample-query" 
                           data-query="SHOW TABLES">
                            <i class="bi bi-arrow-return-right me-2"></i>Show all tables
                        </a>
                        <a href="#" class="list-group-item list-group-item-action sample-query" 
                           data-query="SELECT table_name, table_rows FROM information_schema.tables WHERE table_schema = '{{ env('DB_DATABASE') }}'">
                            <i class="bi bi-arrow-return-right me-2"></i>Show table statistics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-monospace {
        font-family: 'Courier New', Courier, monospace;
    }
    
    .table-item:hover {
        background-color: #f8f9fa;
    }
    
    .sample-query:hover {
        cursor: pointer;
    }
    
    #resultsContent table {
        font-size: 13px;
    }
    
    #resultsContent th {
        position: sticky;
        top: 0;
        background-color: #212529;
        color: white;
        z-index: 1;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const queryForm = document.getElementById('queryForm');
    const queryInput = document.getElementById('queryInput');
    const resultsContainer = document.getElementById('resultsContainer');
    const resultsContent = document.getElementById('resultsContent');
    const resultInfo = document.getElementById('resultInfo');
    const errorContainer = document.getElementById('errorContainer');
    const errorContent = document.getElementById('errorContent');
    const clearBtn = document.getElementById('clearBtn');
    const formatBtn = document.getElementById('formatBtn');

    // Execute query
    queryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const query = queryInput.value.trim();
        if (!query) {
            showError('Please enter a SQL query');
            return;
        }

        // Hide previous results
        resultsContainer.style.display = 'none';
        errorContainer.style.display = 'none';

        // Show loading
        Swal.fire({
            title: 'Executing query...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('{{ route("query-editor.execute") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ query: query })
        })
        .then(response => response.json())
        .then(data => {
            Swal.close();
            
            if (data.success) {
                showResults(data);
            } else {
                showError(data.error || 'An error occurred');
            }
        })
        .catch(error => {
            Swal.close();
            showError('Network error: ' + error.message);
        });
    });

    // Show results
    function showResults(data) {
        resultsContainer.style.display = 'block';
        errorContainer.style.display = 'none';

        if (data.type === 'select') {
            resultInfo.textContent = `${data.count} row(s) returned`;
            
            if (data.data.length > 0) {
                const table = createTable(data.data);
                resultsContent.innerHTML = table;
            } else {
                resultsContent.innerHTML = '<p class="text-muted mb-0">No results found</p>';
            }
        } else {
            resultInfo.textContent = `${data.affected_rows} row(s) affected`;
            resultsContent.innerHTML = `<div class="alert alert-success mb-0">${data.message}</div>`;
        }
    }

    // Show error
    function showError(message) {
        resultsContainer.style.display = 'none';
        errorContainer.style.display = 'block';
        errorContent.textContent = message;
    }

    // Create HTML table from data
    function createTable(data) {
        if (!data || data.length === 0) return '';

        const keys = Object.keys(data[0]);
        
        let html = '<table class="table table-striped table-hover table-sm">';
        html += '<thead class="table-dark"><tr>';
        keys.forEach(key => {
            html += `<th>${escapeHtml(key)}</th>`;
        });
        html += '</tr></thead><tbody>';
        
        data.forEach(row => {
            html += '<tr>';
            keys.forEach(key => {
                const value = row[key];
                html += `<td>${value !== null ? escapeHtml(String(value)) : '<span class="text-muted">NULL</span>'}</td>`;
            });
            html += '</tr>';
        });
        
        html += '</tbody></table>';
        return html;
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Clear button
    clearBtn.addEventListener('click', function() {
        queryInput.value = '';
        resultsContainer.style.display = 'none';
        errorContainer.style.display = 'none';
    });

    // Format button (basic SQL formatting)
    formatBtn.addEventListener('click', function() {
        let query = queryInput.value;
        query = query.replace(/\s+/g, ' ').trim();
        query = query.replace(/\bSELECT\b/gi, 'SELECT\n  ');
        query = query.replace(/\bFROM\b/gi, '\nFROM\n  ');
        query = query.replace(/\bWHERE\b/gi, '\nWHERE\n  ');
        query = query.replace(/\bAND\b/gi, '\n  AND ');
        query = query.replace(/\bOR\b/gi, '\n  OR ');
        query = query.replace(/\bORDER BY\b/gi, '\nORDER BY\n  ');
        query = query.replace(/\bGROUP BY\b/gi, '\nGROUP BY\n  ');
        query = query.replace(/\bLIMIT\b/gi, '\nLIMIT ');
        queryInput.value = query;
    });

    // Sample queries
    document.querySelectorAll('.sample-query').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            queryInput.value = this.getAttribute('data-query');
        });
    });

    // Table click - show structure
    document.querySelectorAll('.table-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const tableName = this.getAttribute('data-table');
            
            Swal.fire({
                title: 'Table Actions',
                html: `What would you like to do with table <strong>${tableName}</strong>?`,
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'View Structure',
                denyButtonText: 'Preview Data',
                cancelButtonText: 'Select Query'
            }).then((result) => {
                if (result.isConfirmed) {
                    queryInput.value = `DESCRIBE ${tableName}`;
                    queryForm.dispatchEvent(new Event('submit'));
                } else if (result.isDenied) {
                    queryInput.value = `SELECT * FROM ${tableName} LIMIT 100`;
                    queryForm.dispatchEvent(new Event('submit'));
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    queryInput.value = `SELECT * FROM ${tableName} LIMIT 10`;
                }
            });
        });
    });
});
</script>
@endsection
