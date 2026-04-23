<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;

class ClanController extends Controller
{
    public function index(Request $request)
    {
        // Get all clans with member count for statistics
        $allClans = Clan::withCount('residents')->get();
        
        // Calculate statistics
        $totalClans = $allClans->count();
        $totalMembers = $allClans->sum('residents_count');
        $averageSize = $totalClans > 0 ? round($totalMembers / $totalClans, 2) : 0;
        $largestClan = $allClans->max('residents_count') ?? 0;

        $sortableColumns = [
            'clan_name' => 'clan_name',
            'head_of_family' => 'head_of_family',
            'address' => 'address',
            'contact' => 'contact_number',
            'members' => 'residents_count',
        ];

        $sort = $request->input('sort', 'clan_name');
        $direction = $request->input('direction', 'asc');

        if (!array_key_exists($sort, $sortableColumns)) {
            $sort = 'clan_name';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'asc';
        }
        
        // Get paginated clans for display
        $clans = Clan::withCount('residents')
            ->orderBy($sortableColumns[$sort], $direction)
            ->paginate(10)
            ->withQueryString()
            ->through(fn($clan) => [
            'id' => $clan->id,
            'clan_name' => $clan->clan_name,
            'head_of_family' => $clan->head_of_family,
            'contact_number' => $clan->contact_number,
            'email' => $clan->email,
            'notes' => $clan->notes,
            'address' => $clan->address,
            'members_count' => $clan->residents_count,
            'head_contacts' => $this->getHeadOfFamilyContacts($clan),
        ]);

        return view('clans.index', [
            'clans' => $clans,
            'sort' => $sort,
            'direction' => $direction,
            'stats' => [
                'total_clans' => $totalClans,
                'total_members' => $totalMembers,
                'average_size' => $averageSize,
                'largest_clan' => $largestClan,
            ]
        ]);
    }

    private function getHeadOfFamilyContacts(Clan $clan)
    {
        if (!$clan->head_of_family) {
            return '';
        }

        // Split head_of_family by comma and trim whitespace
        $headNames = array_map('trim', explode(',', $clan->head_of_family));
        $contacts = [];

        foreach ($headNames as $headName) {
            // Search for resident with matching full name (first_name + last_name)
            $resident = \App\Models\Resident::whereRaw("CONCAT(first_name, ' ', last_name) = ?", [$headName])
                ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) = ?", [$headName])
                ->where('clan_id', $clan->id)
                ->first();

            if ($resident && $resident->contact_number) {
                $contacts[] = $resident->contact_number;
            }
        }

        return implode(', ', $contacts);
    }

    public function getMembers(Clan $clan)
    {
        $members = $clan->residents()->get()->map(function($resident) {
            return [
                'id' => $resident->id,
                'name' => $resident->first_name . ' ' . $resident->last_name,
                'relationship' => $resident->relationship ?? 'Member',
            ];
        });

        return response()->json(['members' => $members]);
    }

    // public function create()
    // {
    //     return view('clans.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'description' => ['nullable', 'string'],
    //     ]);

    //     Clan::create($validated);

    //     return redirect()->route('clans.index')->with('success', 'Clan created successfully!');
    // }

    public function show(Clan $clan)
    {
        return view('clans.show', [
            'clan' => [
                'id' => $clan->id,
                'clan_name' => $clan->clan_name,
                'head_of_family' => $clan->head_of_family,
                'contact_number' => $clan->contact_number,
                'email' => $clan->email,
                'notes' => $clan->notes,
                'address' => $clan->address,
            ]
        ]);
    }

    public function destroy(Clan $clan)
    {
        $clan->delete();

        return redirect()->route('clans.index')->with('success', 'Clan deleted successfully!');
    }
}
