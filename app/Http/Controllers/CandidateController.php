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

    public function store(StoreCandidateRequest $request, CandidateService $candidateService)
    {
        try {
            // dd($request->all());
            $candidateService->createCandidate($request->validated());
            // dd($candidateService);
            return redirect()->route('Candidate.index')->with('success', 'Candidate created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
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


    public function update(UpdateCandidateRequest $request, $uuid, CandidateService $candidateService)
    {
        try {
            $candidateService->updateCandidate($uuid, $request->validated());
            // dd($candidateService);
            return redirect()->route('Candidate.index')->with('success', 'Candidate updated successfully.');
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

        $candidate->delete();

        return redirect()->back()->with('success', 'Candidate deleted successfully.');
    }
}
