<?php

namespace App\Http\Controllers;

use App\Services\AspirasiService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAspirasiRequest;
use App\Models\Aspirasi;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Alert;
use Illuminate\Support\Facades\Response;


class AspirasiController extends Controller
{
    protected $aspirasiService;

    public function __construct(AspirasiService $aspirasiService)
    {
        $this->aspirasiService = $aspirasiService;
    }

    public function index()
    {
        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Aspirasi.index');
        } elseif ($login->role == 'admin') {
            return view('Admin.Aspirasi.index'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->aspirasiService->getAspirasi();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    public function store(StoreAspirasiRequest $request)
    {
        $data = $request->validated();

        try {
            $this->aspirasiService->storeAspirasi($data);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($uuid)
    {
        $aspirasi = $this->aspirasiService->getAspirasiByUuid($uuid);
        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Aspirasi.detail', compact('aspirasi'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Aspirasi.detail', compact('aspirasi'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function destroy($uuid)
    {
        $this->aspirasiService->deleteAspirasi($uuid);

        return response()->json([
            'message' => 'Aspirasi deleted successfully'
        ], 200);
    }
}
