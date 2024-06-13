<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalVotes;
use App\Models\Periode;

class JadwalVotesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwalVotes = JadwalVotes::with('periode')->get();
        return view('jadwal_votes.index', compact('jadwalVotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $periodes = Periode::all();
        return view('jadwal_votes.create', compact('periodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'tanggal_result_vote' => 'required|date',
            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date',
            'tanggal_orasi_vote' => 'required|date',
            'jam_orasi_mulai' => 'required|date_format:H:i',
            'jam_orasi_selesai' => 'required|date_format:H:i|after:jam_orasi_mulai',
            'tempat_orasi' => 'required|string',
        ]);

        JadwalVotes::create($request->all());

        return redirect()->route('jadwal_votes.index')
            ->with('success', 'Jadwal vote created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwalVotes = JadwalVotes::findOrFail($id);
        return view('jadwal_votes.show', compact('jadwalVotes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jadwalVotes = JadwalVotes::findOrFail($id);
        $periodes = Periode::all();
        return view('jadwal_votes.edit', compact('jadwalVotes', 'periodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'periode_id' => 'required|exists:periode,id',
            'tanggal_result_vote' => 'required|date',
            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date',
            'tanggal_orasi_vote' => 'required|date',
            'jam_orasi_mulai' => 'required|date_format:H:i',
            'jam_orasi_selesai' => 'required|date_format:H:i|after:jam_orasi_mulai',
            'tempat_orasi' => 'required|string',
        ]);

        $jadwalVotes = JadwalVotes::findOrFail($id);
        $jadwalVotes->update($request->all());

        return redirect()->route('jadwal_votes.index')
            ->with('success', 'Jadwal vote updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalVotes = JadwalVotes::findOrFail($id);
        $jadwalVotes->delete();
        return redirect()->route('jadwal_votes.index')
            ->with('success', 'Jadwal vote deleted successfully.');
    }
}
