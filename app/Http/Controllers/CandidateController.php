<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Periode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 20);

        // Initialize the query
        $query = Candidates::query();

        // Apply the search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('nama_ketua', 'LIKE', '%' . $search . '%')
                    ->orWhere('nama_wakil_ketua', 'LIKE', '%' . $search . '%');
            });
        }

        // Fetch candidates with selected columns
        $candidates = $query->select(['id', 'nama_ketua', 'nama_wakil_ketua', 'foto', 'slug'])
            ->orderBy('nama_ketua', 'ASC')
            ->paginate($perPage)
            ->withQueryString();

        return view('Superadmin.Candidate.index', compact('candidates'));
    }

    public function create()
    {
        $periodes = Periode::all();
        return view('Superadmin.Candidate.create', compact('periodes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nama_wakil_ketua' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:candidates,slug', // Set slug as nullable
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'periode_id' => 'nullable|exists:periode,id', // Set periode_id as nullable
        ]);

        // Ambil periode_id dari Periode yang aktif
        $periode_id = Periode::where('actif', 1)->value('id');
        $validatedData['periode_id'] = $periode_id;

        // Buat slug secara otomatis jika tidak disediakan
        if (empty($validatedData['slug'])) {
            $baseSlug = Str::slug($validatedData['nama_ketua'] . '-' . $validatedData['nama_wakil_ketua'], '-');
            $slug = $baseSlug;

            // Tambahkan string acak untuk memastikan slug unik
            while (Candidates::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . Str::random(6);
            }

            $validatedData['slug'] = $slug;
        }

        if ($request->hasFile('foto')) {
            $validatedData['foto'] = $request->file('foto')->store('photos', 'public');
        }

        Candidates::create($validatedData);

        return redirect()->route('Candidate.index')->with('success', 'Candidate created successfully.');
    }

    public function show($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();
        return view('Superadmin.Candidate.show', compact('candidate'));
    }

    public function edit($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();
        $periodes = Periode::all();
        return view('Superadmin.Candidate.edit', compact('candidate', 'periodes'));
    }

    public function update(Request $request, $slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();

        // Retrieve the active periode_id before validation
        $periode_id = Periode::where('actif', 1)->value('id');
        if (!$periode_id) {
            return redirect()->back()->withErrors(['periode_id' => 'No active periode found.'])->withInput();
        }

        // Merge periode_id into the request data for validation
        $request->merge(['periode_id' => $periode_id]);

        $validatedData = $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nama_wakil_ketua' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:candidates,slug,' . $candidate->id,
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'periode_id' => 'required|exists:periode,id',
        ]);

        // Check if the name has changed
        $namaDiubah = $candidate->nama_ketua !== $validatedData['nama_ketua'] || $candidate->nama_wakil_ketua !== $validatedData['nama_wakil_ketua'];

        // Generate slug if not provided or if name has changed
        if (empty($validatedData['slug']) || $namaDiubah) {
            $baseSlug = Str::slug($validatedData['nama_ketua'] . '-' . $validatedData['nama_wakil_ketua'], '-');
            $newSlug = $baseSlug;

            // Ensure the slug is unique
            while (Candidates::where('slug', $newSlug)->where('id', '!=', $candidate->id)->exists()) {
                $newSlug = $baseSlug . '-' . Str::random(6);
            }

            $validatedData['slug'] = $newSlug;
        }

        // Handle the photo upload
        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists
            if ($candidate->foto) {
                Storage::disk('public')->delete($candidate->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('photos', 'public');
        }

        $candidate->update($validatedData);

        return redirect()->route('Candidate.index')->with('success', 'Candidate updated successfully.');
    }

    public function destroy($slug)
    {
        $candidate = Candidates::where('slug', $slug)->firstOrFail();

        if ($candidate->foto) {
            Storage::disk('public')->delete($candidate->foto);
        }

        $candidate->delete();

        return redirect()->route('Candidate.index')->with('success', 'Candidate deleted successfully.');
    }
}
