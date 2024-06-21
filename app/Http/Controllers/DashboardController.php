<?php

namespace App\Http\Controllers;

use App\Models\SettingVote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexSuperadmin()
    {
        $statusvote = SettingVote::select("id", "set_vote")->get();
        
        $statusvote1 = SettingVote::value('set_vote');
        // dd($statusvote1);
        return view('superadmin.Dashboard.index', compact('statusvote'));
    }
    public function indexAdmin()
    {
        $statusvote = SettingVote::select("id", "set_vote")->get();
        
        $statusvote1 = SettingVote::value('set_vote');
        // dd($statusvote1);
        return view('superadmin.Dashboard.index', compact('statusvote'));
    }

    public function Settingvote(Request $request)
    {
        // Ambil nilai baru dari request
        $newStatus = $request->input('set_vote');

        // Update nilai di database menggunakan instance model
        $settingVote = SettingVote::first(); // Asumsikan hanya ada satu baris data
        if ($settingVote) {
            $settingVote->set_vote = $newStatus;
            $settingVote->save();

            // Berikan respons JSON
            $message = $newStatus ? 'setting berhasil di buka.' : 'setting berhasil di tutup.';
            return response()->json(['success' => true, 'message' => $message]);
        } else {
            return response()->json(['success' => false, 'message' => 'setting gagal.']);
        }
    }
}
