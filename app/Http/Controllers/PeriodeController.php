<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\SettingVote;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        return view('Superadmin.Periode.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Periode::select('id', 'uuid', 'periode_nama', 'periode_kepala_sekolah', 'periode_no_kepala_sekolah', 'actif');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function create()
    {
        return view('Superadmin.Periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_nama' => [
                'required',
                'regex:/^\d{4}-\d{4}$/',
                function ($attribute, $value, $fail) {
                    [$startYear, $endYear] = explode('-', $value);
                    if ((int)$startYear >= (int)$endYear) {
                        $fail('Tahun pertama harus lebih kecil dari tahun kedua.');
                    }
                },
            ],
            'periode_kepala_sekolah' => 'required',
            'periode_no_kepala_sekolah' => 'required',
            'actif' => 'required|integer|in:1,2',
        ]);
        // cek apakah ada nama periode yang sama
        if (Periode::where('periode_nama', $request->periode_nama)->exists()) {
            return redirect()->back()->with('error', 'Periode sudah ada.');
        }
        // Cek apakah ada periode dengan actif = 1
        $actifPeriode = Periode::where('actif', 1)->exists();

        if ($actifPeriode && $request->actif == 1) {
            return redirect()->back()->with('error', 'Terdapat periode yang masih aktif, mohon diganti statusnya tidak aktif.');
        }

        Periode::create($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode created successfully.');
    }


    public function edit($uuid)
    {
        $periode = Periode::where('uuid', $uuid)->firstOrFail();
        if(!$periode){
            return redirect()->route('periode.index')->with('error', 'Periode not found.');
        }
        return view('Superadmin.Periode.edit', compact('periode'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'periode_nama' => 'required',
            'periode_kepala_sekolah' => 'required',
            'periode_no_kepala_sekolah' => 'required',
            'actif' => 'required|integer|in:1,2',
        ]);
        $periode = Periode::where('uuid', $uuid)->firstOrFail();
        if (!$periode) {
            return redirect()->route('periode.index')->with('error', 'Periode not found.');
        }
        // Cek apakah ada periode dengan actif = 1
        $actifPeriode = Periode::where('actif', 1)->exists();

        if ($actifPeriode && $request->actif == 1) {
            // Jika ada, lakukan sesuatu, contohnya:
            return redirect()->back()->with('error', 'Terdapat periode yang masih aktif.');
        }
        $periode->update($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode updated successfully.');
    }

    public function destroy($uuid)
    {
        $periode = Periode::where('uuid', $uuid)->firstOrFail();
        if (!$periode) {
            return redirect()->route('periode.index')->with('error', 'Periode not found.');
        }
        $periode->delete();
        return redirect()->back()->with('success', 'Periode deleted successfully.');
    }
}
