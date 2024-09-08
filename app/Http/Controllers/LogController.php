<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $login = Auth::user();

        if ($login->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        return view('Superadmin.Log.index');
    }

    public function list(Request $request)
    {
        $login = Auth::user();
        if ($login->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        $periode_active = Periode::where('actif', 1)->first();
        $data = Log::with('user', 'periode')->select("uuid", "action", "url", "tanggal", "waktu", "data", "user_id", "periode_id")->where('periode_id', $periode_active->id)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function show(string $uuid)
    {
        $login = Auth::user();

        if ($login->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $checkdata = Log::where('uuid', $uuid)->first();
        if (!$checkdata) {
            return back()->with('error', 'Data Log Tidak Ditemukan');
        }

        $periode_active = Periode::where('actif', 1)->first();
        if (!$periode_active) {
            return back()->with('error', 'Periode aktif tidak ditemukan');
        }

        $data = Log::with('user', 'periode')->select("uuid", "action", "url", "tanggal", "waktu", "data", "user_id", "periode_id")
            ->where('uuid', $uuid)
            ->where('periode_id', $periode_active->id)
            ->first();

        if (!$data) {
            return back()->with('error', 'Data Log tidak ditemukan di periode aktif.');
        }

        return view('Superadmin.Log.show', compact('data'));
    }

    public function destroy(string $uuid)
    {
        // Ambil pengguna yang sedang login
        $login = Auth::user();

        // Pengecekan apakah user adalah superadmin
        if ($login->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        // Cek apakah log dengan UUID tersebut ada
        $log = Log::where('uuid', $uuid)->first();
        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'Data Log tidak ditemukan'
            ], 404);
        }

        // Ambil periode yang aktif
        $periode_active = Periode::where('actif', 1)->first();
        // Pastikan log yang akan dihapus sesuai dengan periode aktif
        if ($log->periode_id !== $periode_active->id) {
            return response()->json([
                'success' => false,
                'message' => 'Log tidak berada dalam periode aktif'
            ], 404);
        }
        if (!$periode_active) {
            return response()->json([
                'success' => false,
                'message' => 'Periode aktif tidak ditemukan'
            ], 404);
        }


        // Hapus log
        $log->delete();

        // Buat log untuk pencatatan penghapusan
        $currentUrl = url()->current();
        $cleanedUrl = preg_replace('/\/[a-f0-9\-]{36}/', '', $currentUrl);

        $logAction = new Log();
        $logAction->action = 'delete';
        $logAction->url = $cleanedUrl;
        $logAction->tanggal = now()->format('Y-m-d');
        $logAction->waktu = now()->format('H:i:s');
        $logAction->data = 'User Name: ' . $login->name . ' | Deleted log with UUID: ' . $uuid;
        $logAction->periode_id = $periode_active->id;
        $logAction->user_id = $login->id;
        $logAction->save();

        // Redirect dengan pesan sukses
        return response()->json([
            'success' => true,
            'message' => 'Log Berhasil Dihapus',
            'profile' => $logAction
        ], 200);
    }
}
