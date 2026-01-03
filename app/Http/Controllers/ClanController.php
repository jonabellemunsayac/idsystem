<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Http\Request;

class ClanController extends Controller
{
    public function index(Request $request)
    {
        $clans = Clan::paginate(10)->through(fn($clan) => [
            'id' => $clan->id,
            'name' => $clan->name,
            'description' => $clan->description,
        ]);

        return view('clans.index', ['clans' => $clans]);
    }

    public function create()
    {
        return view('clans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Clan::create($validated);

        return redirect()->route('clans.index')->with('success', 'Clan created successfully!');
    }

    public function show(Clan $clan)
    {
        return view('clans.show', [
            'clan' => [
                'id' => $clan->id,
                'name' => $clan->name,
                'description' => $clan->description,
            ]
        ]);
    }

    public function destroy(Clan $clan)
    {
        $clan->delete();

        return redirect()->route('clans.index')->with('success', 'Clan deleted successfully!');
    }
}
