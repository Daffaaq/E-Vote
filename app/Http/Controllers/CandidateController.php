<?php

namespace App\Http\Controllers;

use App\Models\Candidates;
use App\Http\Requests\StoreCandidateRequest;
use App\Services\CandidateService;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Periode;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $candidates = Candidates::where('periode_id', $periode_id)->select("status")->first();

        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Candidate.index', compact('candidates'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Candidate.index', compact('candidates'));
        } else {
            abort(403, 'Unauthorized action.');
        }
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
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.Candidate.create');
        } elseif ($login->role == 'admin') {
            return view('Admin.Candidate.create');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function store(StoreCandidateRequest $request, CandidateService $candidateService)
    {
        try {
            // dd($request->all());
            $candidateService->createCandidate($request->validated());
            // dd($candidateService);
            $login = Auth::user();
            if ($login->role == 'superadmin') {
                return redirect()->route('Candidate.index')->with('success', 'Candidate created successfully.');
            } elseif ($login->role == 'admin') {
                return redirect()->route('Candidate.admin.index')->with('success', 'Candidate created successfully.');
            } else {
                abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function show($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail(); // Mengambil data kandidat berdasarkan UUID
        // dd($candidate);
        $login = Auth::user();
        $periode = $candidate->periode; // Mengambil data periode yang terkait dengan kandidat

        if ($login->role == 'superadmin') {
            return view('Superadmin.Candidate.detail', compact('candidate', 'periode'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Candidate.detail', compact('candidate', 'periode'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function edit($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();
        $periodes = Periode::all();

        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Candidate.edit', compact('candidate', 'periodes'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Candidate.edit', compact('candidate', 'periodes'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function update(UpdateCandidateRequest $request, $uuid, CandidateService $candidateService)
    {
        try {
            $candidateService->updateCandidate($uuid, $request->validated());
            // dd($candidateService);

            $login = Auth::user();
            if ($login->role == 'superadmin') {
                return redirect()->route('Candidate.index')->with('success', 'Candidate updated successfully.');
            } elseif ($login->role == 'admin') {
                return redirect()->route('Candidate.admin.index')->with('success', 'Candidate updated successfully.');
            } else {
                abort(403, 'Unauthorized action.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }


    public function destroy($uuid)
    {
        $candidate = Candidates::where('uuid', $uuid)->firstOrFail();

        if ($candidate->foto) {
            Storage::disk('public')->delete($candidate->foto);
        }

        $periode = $candidate->periode;

        // Logging
        $logData = 'Deleted Candidate | Nama Ketua: ' . $candidate->nama_ketua .
            ($candidate->status === 'ganda' ? ' | Nama Wakil: ' . $candidate->nama_wakil_ketua : '') .
            ' | Slogan: ' . $candidate->slogan .
            ' | Periode: ' . $periode->periode_nama;

        $logEntry = [
            'action' => 'delete',
            'url' => request()->url(),
            'tanggal' => now()->toDateString(),
            'waktu' => now()->toTimeString(),
            'data' => $logData,
            'periode_id' => $periode->id,
            'user_id' => auth()->id(),
        ];

        \App\Models\Log::create($logEntry);

        $candidate->delete();

        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('Candidate.index')->with('success', 'Candidate deleted successfully.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('Candidate.admin.index')->with('success', 'Candidate deleted successfully.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
