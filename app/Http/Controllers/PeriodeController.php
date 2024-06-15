<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\SettingVote;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 20);

        // Initialize the query
        $query = Periode::query();
        $periodes =
            Periode::paginate(10);

        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == '1' || $status == '2') {
                $query->where('actif', $status);
            }
            // No need for filtering if status is 'All'
        }

        // Apply the search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('periode_nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('periode_kepala_sekolah', 'LIKE', '%' . $search . '%')
                    ->orWhere('periode_no_kepala_sekolah', 'LIKE', '%' . $search . '%');
            });
        }
        $periodes = $query->select(['id', 'periode_nama', 'periode_kepala_sekolah', 'periode_no_kepala_sekolah', 'actif'])
            ->orderBy('periode_nama', 'ASC')
            ->paginate($perPage)
            ->withQueryString();

        return view('Superadmin.Periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('Superadmin.Periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'periode_nama' => 'required',
            'periode_kepala_sekolah' => 'required',
            'periode_no_kepala_sekolah' => 'required',
            'actif' => 'required|integer|in:1,2',
        ]);

        $actifPeriode = Periode::where('actif', 1)->exists();

        // Jika ada periode yang masih aktif dan inputannya juga aktif, kembalikan ke halaman sebelumnya dengan pesan error
        if ($actifPeriode && $request->actif == 1) {
            return redirect()->back()->with('error', 'Terdapat periode yang masih aktif, mohon diganti statusnya tidak aktif.');
        }

        Periode::create($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode created successfully.');
    }

    public function edit($id)
    {
        $periode = Periode::findOrFail($id);
        return view('Superadmin.Periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'periode_nama' => 'required',
            'periode_kepala_sekolah' => 'required',
            'periode_no_kepala_sekolah' => 'required',
            'actif' => 'required|integer|in:1,2',
        ]);
        $periode = Periode::findOrFail($id);
        // Cek apakah ada periode dengan actif = 1
        $actifPeriode = Periode::where('actif', 1)->exists();

        if ($actifPeriode) {
            // Jika ada, lakukan sesuatu, contohnya:
            return redirect()->route('periode.index')->with('error', 'Terdapat periode yang masih aktif.');
        }
        $periode->update($request->all());

        return redirect()->route('periode.index')->with('success', 'Periode updated successfully.');
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode deleted successfully.');
    }
}
