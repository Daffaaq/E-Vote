<?php

namespace App\Http\Controllers;

use App\Services\JadwalService;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalResultRequest;
use App\Http\Requests\UpdateJadwalOrasiRequest;
use App\Http\Requests\UpdateJadwalVoteRequest;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    protected $jadwalService;

    public function __construct(JadwalService $jadwalService)
    {
        $this->jadwalService = $jadwalService;
    }

    // public function index()
    // {
    //     $periode_id = Periode::where('actif', 1)->value('id');
    //     $jadwal = $this->jadwalService->getJadwalForPeriode($periode_id);
    //     // Extracting relevant data from the $jadwal
    //     $jadwalOrasi = $jadwal['jadwalOrasi'] ?? collect();
    //     $jadwalVotes = $jadwal['jadwalVotes'] ?? collect();
    //     $jadwalResultVote = $jadwal['jadwalResultVote'] ?? collect();

    //     // Prepare parameters for form action
    //     $params = [];
    //     if (
    //         $jadwalOrasi->isNotEmpty() &&
    //         $jadwalVotes->isNotEmpty() &&
    //         $jadwalResultVote->isNotEmpty()
    //     ) {
    //         $params['uuidOrasi'] = $jadwalOrasi->first()->uuid;
    //         $params['uuidVotes'] = $jadwalVotes->first()->uuid;
    //         $params['uuidResult'] = $jadwalResultVote->first()->uuid;
    //     } elseif ($jadwalOrasi->isNotEmpty() && $jadwalVotes->isNotEmpty()) {
    //         $params['uuidOrasi'] = $jadwalOrasi->first()->uuid;
    //         $params['uuidVotes'] = $jadwalVotes->first()->uuid;
    //     } elseif ($jadwalOrasi->isNotEmpty() && $jadwalResultVote->isNotEmpty()) {
    //         $params['uuidOrasi'] = $jadwalOrasi->first()->uuid;
    //         $params['uuidResult'] = $jadwalResultVote->first()->uuid;
    //     } elseif ($jadwalVotes->isNotEmpty() && $jadwalResultVote->isNotEmpty()) {
    //         $params['uuidVotes'] = $jadwalVotes->first()->uuid;
    //         $params['uuidResult'] = $jadwalResultVote->first()->uuid;
    //     } elseif ($jadwalOrasi->isNotEmpty()) {
    //         $params['uuidOrasi'] = $jadwalOrasi->first()->uuid;
    //     } elseif ($jadwalVotes->isNotEmpty()) {
    //         $params['uuidVotes'] = $jadwalVotes->first()->uuid;
    //     } elseif ($jadwalResultVote->isNotEmpty()) {
    //         $params['uuidResult'] = $jadwalResultVote->first()->uuid;
    //     }
    //     return view('Superadmin.jadwal.index', $jadwal, compact('params'));
    // }
    public function index()
    {
        $periode_id = Periode::where('actif', 1)->value('id');
        // dd($periode_id);
        $jadwal = $this->jadwalService->getJadwalForPeriode($periode_id);

        // Extracting relevant data from the $jadwal array
        $jadwalOrasi = $jadwal['jadwalOrasi'] ?? collect();
        $jadwalVotes = $jadwal['jadwalVotes'] ?? collect();
        $jadwalResultVote = $jadwal['jadwalResultVote'] ?? collect();

        // dd($jadwalOrasi, $jadwalVotes, $jadwalResultVote);

        // Prepare parameters for form action
        $routeParams = [
            $jadwalOrasi->isNotEmpty() ? $jadwalOrasi->first()->uuid : null,
            $jadwalVotes->isNotEmpty() ? $jadwalVotes->first()->uuid : null,
            $jadwalResultVote->isNotEmpty() ? $jadwalResultVote->first()->uuid : null,
        ];

        // Filter out null values and create the URL
        $filteredParams = implode('/', array_filter($routeParams));
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            $routeUrl = url("dashboardSuperadmin/jadwal/delete-all/{$filteredParams}");

            // Pass data to the view
            return view('Superadmin.jadwal.index', [
                'jadwalOrasi' => $jadwalOrasi,
                'jadwalVotes' => $jadwalVotes,
                'jadwalResultVote' => $jadwalResultVote,
                'routeUrl' => $routeUrl,
            ]);
        } elseif ($login->role == 'admin') {
            $routeUrl = url("dashboardAdmin/jadwal/delete-all/{$filteredParams}");
            return view('Admin.jadwal.index', [
                'jadwalOrasi' => $jadwalOrasi,
                'jadwalVotes' => $jadwalVotes,
                'jadwalResultVote' => $jadwalResultVote,
                'routeUrl' => $routeUrl,
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }





    public function create()
    {
        if ($this->jadwalService->checkIfJadwalExists()) {
            return redirect()->route('jadwal.index')->with('error', 'Jadwal sudah ada.');
        }
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.jadwal.create');
        } elseif ($login->role == 'admin') {
            return view('Admin.jadwal.create');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    public function store(StoreJadwalRequest $request)
    {
        $validatedData = $request->validated();
        $periode_id = Periode::where('actif', 1)->value('id');
        $this->jadwalService->storeJadwal($validatedData, $periode_id);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal berhasil ditambahkan.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function editOrasi($uuid)
    {
        $jadwal_orasi = $this->jadwalService->getJadwalOrasiByUuid($uuid);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.jadwal.editOrasi', compact('jadwal_orasi'));
        } elseif ($login->role == 'admin') {
            return view('Admin.jadwal.editOrasi', compact('jadwal_orasi'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function editVotes($uuid)
    {
        $jadwalVotes = $this->jadwalService->getJadwalVotesByUuid($uuid);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.jadwal.editVotes', compact('jadwalVotes'));
        } elseif ($login->role == 'admin') {
            return view('Admin.jadwal.editVotes', compact('jadwalVotes'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function editResult($uuid)
    {
        $jadwalResultVote = $this->jadwalService->getJadwalResultVoteByUuid($uuid);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.jadwal.editResult', compact('jadwalResultVote'));
        } elseif ($login->role == 'admin') {
            return view('Admin.jadwal.editResult', compact('jadwalResultVote'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updateOrasi(UpdateJadwalOrasiRequest $request, $uuid)
    {
        $validatedData = $request->validated();
        $this->jadwalService->updateJadwalOrasi($uuid, $validatedData);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Orasi berhasil diperbarui.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Orasi berhasil diperbarui.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updateVote(UpdateJadwalVoteRequest $request, $uuid)
    {
        $validatedData = $request->validated();
        $this->jadwalService->updateJadwalVotes($uuid, $validatedData);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Votes berhasil diperbarui.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Votes berhasil diperbarui.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updateResult(UpdateJadwalResultRequest $request, $uuid)
    {
        $validatedData = $request->validated();
        $this->jadwalService->updateJadwalResultVote($uuid, $validatedData);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Pembacaan Hasil berhasil diperbarui.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Pembacaan Hasil berhasil diperbarui.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroyOrasi($uuid)
    {
        $this->jadwalService->deleteJadwalOrasi($uuid);
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Orasi berhasil dihapus.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Orasi berhasil dihapus.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroyVotes($uuid)
    {
        $this->jadwalService->deleteJadwalVotes($uuid);

        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Votes berhasil dihapus.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Votes berhasil dihapus.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroyResult($uuid)
    {
        $this->jadwalService->deleteJadwalResultVote($uuid);

        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('jadwal.index')->with('success', 'Jadwal Pembacaan Hasil berhasil dihapus.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('jadwal.admin.index')->with('success', 'Jadwal Pembacaan Hasil berhasil dihapus.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroyAll($uuidOrasi, $uuidVotes, $uuidResult)
    {
        // Memastikan semua UUID tersedia
        if (!$uuidOrasi || !$uuidVotes || !$uuidResult) {
            return redirect()->route('jadwal.index')->with('error', 'Semua UUID (Orasi, Votes, Result) harus tersedia.');
        }

        // Mendapatkan periode_id aktif
        $periode_id = Periode::where('actif', 1)->value('id');

        // Debugging: Melihat apa yang diterima oleh fungsi
        Log::info("Destroying jadwal with params:", [
            'uuidOrasi' => $uuidOrasi,
            'uuidVotes' => $uuidVotes,
            'uuidResult' => $uuidResult,
            'periode_id' => $periode_id,
        ]);

        // Memanggil service untuk menghapus data
        $deletedCount = $this->jadwalService->destroyAll($uuidOrasi, $uuidVotes, $uuidResult);

        // Redirect dengan pesan sukses atau error berdasarkan hasil penghapusan
        if ($deletedCount > 0) {
            $login = Auth::user();
            if ($login->role == 'superadmin') {
                return redirect()->route('jadwal.index')->with('success', 'Semua jadwal terkait berhasil dihapus.');
            } elseif ($login->role == 'admin') {
                return redirect()->route('jadwal.admin.index')->with('success', 'Semua jadwal terkait berhasil dihapus.');
            } else {
                abort(403, 'Unauthorized action.');
            }
        } else {
            $login = Auth::user();
            if ($login->role == 'superadmin') {
                return redirect()->route('jadwal.index')->with('error', 'Tidak ada jadwal yang dihapus.');
            } elseif ($login->role == 'admin') {
                return redirect()->route('jadwal.admin.index')->with('error', 'Tidak ada jadwal yang dihapus.');
            } else {
                abort(403, 'Unauthorized action.');
            }
            return redirect()->route('jadwal.index')->with('error', 'Tidak ada jadwal yang dihapus.');
        }
    }
}
