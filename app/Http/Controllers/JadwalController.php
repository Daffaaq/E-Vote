<?php

namespace App\Http\Controllers;

use App\Models\jadwal_orasi;
use App\Models\jadwal_result_vote;
use App\Models\JadwalVotes;
use App\Models\Periode;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $periode_id = Periode::where('actif', 1)->value('id'); // Mengambil id dari periode yang aktif

        // Mengambil data dari masing-masing tabel berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->select("uuid", "tanggal_awal_vote", "tanggal_akhir_vote", "tempat_vote")->get();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->select("uuid", "tanggal_result_vote", "jam_result_vote", "tempat_result_vote")->get();
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->select("uuid", "tanggal_orasi_vote", "jam_orasi_mulai", "tempat_orasi")->get();

        return view('Superadmin.jadwal.index', compact('jadwalVotes', 'jadwalResultVote', 'jadwalOrasi'));
    }

    public function create()
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        
        // pengecekan apakah masing masing model sudah ada datanya
        $jadwalOrasi = jadwal_orasi::where('periode_id', $periode_id)->first();
        $jadwalVotes = JadwalVotes::where('periode_id', $periode_id)->first();
        $jadwalResultVote = jadwal_result_vote::where('periode_id', $periode_id)->first();
        if ($jadwalOrasi && $jadwalVotes && $jadwalResultVote) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal sudah ada.');
        }
        return view('Superadmin.jadwal.create');
    }

    public function store(Request $request)
    {
        // Validasi data sesuai dengan langkah yang dikirimkan
        $validatedData = $request->validate([
            // Validasi untuk setiap langkah (orasi, votes, result_vote)
            'tanggal_orasi_vote' => 'required|date',
            'jam_orasi_mulai' => 'required|date_format:H:i',
            'tempat_orasi' => 'required|string|max:255',

            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date|after_or_equal:tanggal_awal_vote',
            'tempat_vote' => 'required|string|max:255',

            'tanggal_result_vote' => 'required|date',
            'jam_result_vote' => 'required|date_format:H:i',
            'tempat_result_vote' => 'required|string|max:255',
        ]);


        // Ambil ID periode yang aktif (misalnya dari model Periode)
        $periode_id = Periode::where('actif', 1)->value('id');
        $jadwalOrasi = jadwal_orasi::create([
            'periode_id' => $periode_id,
            'tanggal_orasi_vote' => $validatedData['tanggal_orasi_vote'],
            'jam_orasi_mulai' => $validatedData['jam_orasi_mulai'],
            'tempat_orasi' => $validatedData['tempat_orasi'],
        ]);
        $jadwalVotes = JadwalVotes::create([
            'periode_id' => $periode_id,
            'tanggal_awal_vote' => $validatedData['tanggal_awal_vote'],
            'tanggal_akhir_vote' => $validatedData['tanggal_akhir_vote'],
            'tempat_vote' => $validatedData['tempat_vote'],
        ]);
        $jadwalResultVote = jadwal_result_vote::create([
            'periode_id' => $periode_id,
            'tanggal_result_vote' => $validatedData['tanggal_result_vote'],
            'jam_result_vote' => $validatedData['jam_result_vote'],
            'tempat_result_vote' => $validatedData['tempat_result_vote'],
        ]);
        // Jika langkah tidak diketahui, kembalikan ke halaman indeks dengan pesan yang sesuai
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }



    public function editOrasi($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $jadwal_orasi = jadwal_orasi::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Pass the records to the view
        return view('Superadmin.jadwal.editOrasi', compact('jadwal_orasi'));
    }

    public function editVotes($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $jadwalVotes = JadwalVotes::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Pass the records to the view
        return view('Superadmin.jadwal.editVotes', compact('jadwalVotes'));
    }

    public function editResult($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Pass the records to the view
        return view('Superadmin.jadwal.editResult', compact('jadwalResultVote'));
    }


    public function updateOrasi(Request $request, $uuid)
    {
        // Validasi data
        $request->validate([
            'tanggal_orasi_vote' => 'required|date',
            'jam_orasi_mulai' => 'required',
            'tempat_orasi' => 'required|string|max:255',
        ]);
        $periode_id = Periode::where('actif', 1)->value('id');
        // Temukan data yang sesuai berdasarkan periode_id
        $jadwalOrasi = jadwal_orasi::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Update JadwalOrasi
        $jadwalOrasi->update([
            'tanggal_orasi_vote' => $request->tanggal_orasi_vote,
            'jam_orasi_mulai' => $request->jam_orasi_mulai,
            'tempat_orasi' => $request->tempat_orasi,
            'updated_at' => now(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function updateVote(Request $request, $uuid)
    {
        // Validasi data
        $request->validate([
            'tanggal_awal_vote' => 'required|date',
            'tanggal_akhir_vote' => 'required|date|after_or_equal:tanggal_awal_vote',
            'tempat_vote' => 'required|string|max:255',
        ]);
        $periode_id = Periode::where('actif', 1)->value('id');
        // Temukan data yang sesuai berdasarkan periode_id
        $jadwalVotes = JadwalVotes::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Update JadwalVotes
        $jadwalVotes->update([
            'tanggal_awal_vote' => $request->tanggal_awal_vote,
            'tanggal_akhir_vote' => $request->tanggal_akhir_vote,
            'tempat_vote' => $request->tempat_vote,
            'updated_at' => now(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function updateResult(Request $request, $uuid)
    {
        // Validasi data
        $request->validate([
            'tanggal_result_vote' => 'required|date',
            'jam_result_vote' => 'required',
            'tempat_result_vote' => 'required|string|max:255',
        ]);
        $periode_id = Periode::where('actif', 1)->value('id');
        // Temukan data yang sesuai berdasarkan periode_id
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuid)->where('periode_id', $periode_id)->firstOrFail();

        // Update JadwalResultVote
        $jadwalResultVote->update([
            'tanggal_result_vote' => $request->tanggal_result_vote,
            'jam_result_vote' => $request->jam_result_vote,
            'tempat_result_vote' => $request->tempat_result_vote,
            'updated_at' => now(),
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal Pembacaan Hasil berhasil diperbarui.');
    }



    public function show()
    {
        return view('Superadmin.jadwal.show');
    }

    public function destroyOrasi($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');

        // Cari dan hapus data yang sesuai dengan id dan periode_id

        $jadwalOrasi = jadwal_orasi::where('uuid', $uuid)->where('periode_id', $periode_id)->first();
        $jadwalOrasi->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal Orasi berhasil dihapus.');
    }
    public function destroyVotes($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');

        // Cari dan hapus data yang sesuai dengan id dan periode_id
        $jadwalVotes = JadwalVotes::where('uuid', $uuid)->where('periode_id', $periode_id)->first();

        $jadwalVotes->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal Votes berhasil dihapus.');
    }
    public function destroyResult($uuid)
    {
        $periode_id = Periode::where('actif', 1)->value('id');

        // Cari dan hapus data yang sesuai dengan id dan periode_id
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuid)->where('periode_id', $periode_id)->first();
        $jadwalResultVote->delete();

        return redirect()->route('jadwal.index')->with('success', 'jadwal Pembacaan hasil berhasil dihapus.');
    }

    public function destroyAll($uuidOrasi, $uuidVotes, $uuidResult)
    {
        $periode_id = Periode::where('actif', 1)->value('id');

        // Hapus Jadwal Orasi
        $jadwalOrasi = jadwal_orasi::where('uuid', $uuidOrasi)->where('periode_id', $periode_id)->first();
        if ($jadwalOrasi) {
            $jadwalOrasi->delete();
        }

        // Hapus Jadwal Votes
        $jadwalVotes = JadwalVotes::where('uuid', $uuidVotes)->where('periode_id', $periode_id)->first();
        if ($jadwalVotes) {
            $jadwalVotes->delete();
        }

        // Hapus Jadwal Result Vote
        $jadwalResultVote = jadwal_result_vote::where('uuid', $uuidResult)->where('periode_id', $periode_id)->first();
        if ($jadwalResultVote) {
            $jadwalResultVote->delete();
        }

        return redirect()->route('jadwal.index')->with('success', 'Semua jadwal terkait berhasil dihapus.');
    }
}
