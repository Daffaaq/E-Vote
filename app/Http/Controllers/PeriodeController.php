<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Services\PeriodeService;
use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    protected $periodeService;

    public function __construct(PeriodeService $periodeService)
    {
        $this->periodeService = $periodeService;
    }

    public function index(Request $request)
    {
        return view('Superadmin.Periode.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->periodeService->getAllPeriode();
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

    public function store(StorePeriodeRequest $request)
    {
        $result = $this->periodeService->createPeriode($request);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('periode.index')->with('success', 'Periode berhasil dibuat.');
    }

    public function edit($uuid)
    {
        $periode = $this->periodeService->findByUUID($uuid);
        return view('Superadmin.Periode.edit', compact('periode'));
    }

    public function update(UpdatePeriodeRequest $request, $uuid)
    {
        $result = $this->periodeService->updatePeriode($request, $uuid);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->route('periode.index')->with('success', 'Periode berhasil di perbaharui.');
    }

    public function destroy($uuid)
    {
        $result = $this->periodeService->deletePeriode($uuid);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->back()->with('success', 'Periode berhasil dihapus.');
    }
}
