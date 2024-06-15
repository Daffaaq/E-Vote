<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Periode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $candidates = Candidates::all();
        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        $periodes = Periode::all();
        return view('candidates.create', compact('periodes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|unique:candidates,slug',
            'visi' => 'required',
            'misi' => 'required',
            'desc' => 'required',
            'foto' => 'nullable|image',
            'Kelas' => 'required|string',
            'link' => 'nullable|url',
            'periode_id' => 'required|exists:periode,id',
        ]);

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('photos', 'public');
        }

        Candidates::create($validatedData);

        return redirect()->route('candidates.index')->with('success', 'Candidate created successfully.');
    }

    public function show($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();
        return view('candidates.show', compact('candidate'));
    }

    public function edit($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();
        $periodes = Periode::all();
        return view('candidates.edit', compact('candidate', 'periodes'));
    }

    public function update(Request $request, $slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'required|string|unique:candidates,slug,' . $candidate->id,
            'visi' => 'required',
            'misi' => 'required',
            'desc' => 'required',
            'foto' => 'nullable|image',
            'Kelas' => 'required|string',
            'link' => 'nullable|url',
            'periode_id' => 'required|exists:periode,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($candidate->foto) {
                Storage::disk('public')->delete($candidate->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('photos', 'public');
        }

        $candidate->update($validatedData);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();

        if ($candidate->foto) {
            Storage::disk('public')->delete($candidate->foto);
        }

        $candidate->delete();

        return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully.');
    }
}
