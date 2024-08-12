<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Models\Periode;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $candidates = Candidates::where('periode_id', $periode_id)->select("status")->first();

        return view('Superadmin.Candidate.index', compact('candidates'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $periode_id = Periode::where('actif', 1)->value('id');
            if (!$periode_id) {
                return response()->json(['message' => 'No active periode found.'], 404);
            }

            // Dapatkan satu kandidat untuk memeriksa statusnya
            $candidate = Candidates::where('periode_id', $periode_id)->select('status')->first();

            // Mulai membangun query dasar
            $data = Candidates::where('periode_id', $periode_id)
                ->select('id', 'uuid', 'nama_ketua', 'slogan');

            // Jika status adalah 'ganda', tambahkan kolom 'nama_wakil_ketua'
            if ($candidate && $candidate->status == 'ganda') {
                $data->addSelect('nama_wakil_ketua');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function create()
    {
        return view('Superadmin.Candidate.create');
    }

    public function store(Request $request)
    {
        // Validasi umum
        $validatedData = $request->validate([
            'status' => 'required|in:perseorangan,ganda',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil_ketua' => 'nullable|string|max:255', // Ubah 'required' ke 'nullable'
            'slug' => 'nullable|string|unique:candidates,slug',
            'no_urut_kandidat' => 'required|numeric',
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'periode_id' => 'nullable|exists:periode,id',
        ]);

        // Check for sequential and unique no_urut_kandidat
        $lastNumber = Candidates::max('no_urut_kandidat');
        $expectedNumber = $lastNumber + 1;

        if ($validatedData['no_urut_kandidat'] != $expectedNumber) {
            return redirect()->back()->withErrors([
                'no_urut_kandidat' => "Nomor urut kandidat harus berurutan dan tidak boleh ada yang terlewat. Silakan masukkan nomor yang benar ($expectedNumber).",
            ])->withInput();
        }

        if (Candidates::where('no_urut_kandidat', $validatedData['no_urut_kandidat'])->exists()) {
            return redirect()->back()->withErrors(['no_urut_kandidat' => 'Nomor urut kandidat sudah ada.'])->withInput();
        }

        // Jika statusnya 'perseorangan', pastikan nama_wakil_ketua tidak diisi
        if ($validatedData['status'] === 'perseorangan' && !empty($validatedData['nama_wakil_ketua'])) {
            return redirect()->back()->withErrors(['nama_wakil_ketua' => 'Nama wakil ketua tidak diperlukan jika status adalah perseorangan.'])->withInput();
        }

        // Jika statusnya 'ganda', pastikan nama_wakil_ketua diisi
        if ($validatedData['status'] === 'ganda' && empty($validatedData['nama_wakil_ketua'])) {
            return redirect()->back()->withErrors(['nama_wakil_ketua' => 'Nama wakil ketua diperlukan jika status adalah ganda.'])->withInput();
        }

        // Ambil periode_id dari Periode yang aktif
        $periode_id = Periode::where('actif', 1)->value('id');
        $validatedData['periode_id'] = $periode_id;

        // Buat slug secara otomatis jika tidak disediakan
        if (empty($validatedData['slug'])) {
            // Membuat slug berdasarkan status
            if ($validatedData['status'] === 'perseorangan') {
                $baseSlug = Str::slug($validatedData['nama_ketua'], '-');
            } else {
                $baseSlug = Str::slug($validatedData['nama_ketua'] . '-' . $validatedData['nama_wakil_ketua'], '-');
            }

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


    public function show($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();
        return view('Superadmin.Candidate.show', compact('candidate'));
    }

    public function edit($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();
        $periodes = Periode::all();
        return view('Superadmin.Candidate.edit', compact('candidate', 'periodes'));
    }


    public function update(Request $request, $uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();

        // Retrieve the active periode_id before validation
        $periode_id = Periode::where('actif', 1)->value('id');
        if (!$periode_id) {
            return redirect()->back()->withErrors(['periode_id' => 'No active periode found.'])->withInput();
        }

        // Merge periode_id into the request data for validation
        $request->merge(['periode_id' => $periode_id]);

        // Validate the request
        $validatedData = $request->validate([
            'status' => 'required|in:perseorangan,ganda',
            'nama_ketua' => 'nullable|string|max:255',
            'nama_wakil_ketua' => 'nullable|string|max:255',
            'visi' => 'required',
            'misi' => 'required',
            'slogan' => 'required',
            'foto' => 'nullable|image',
            'periode_id' => 'required|exists:periode,id',
        ]);

        // Handle the photo upload
        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists
            if ($candidate->foto) {
                Storage::disk('public')->delete($candidate->foto);
            }

            // Store the new photo
            $validatedData['foto'] = $request->file('foto')->store('photos', 'public');
        }

        // Update the candidate
        $candidate->update($validatedData);

        return redirect()->route('Candidate.index')->with('success', 'Candidate updated successfully.');
    }


    public function destroy($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();

        if ($candidate->foto) {
            Storage::disk('public')->delete($candidate->foto);
        }

        $candidate->delete();

        return redirect()->back()->with('success', 'Candidate deleted successfully.');
    }
}
