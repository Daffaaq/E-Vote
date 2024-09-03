<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use App\Imports\StudentImport;
use App\Models\Periode;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    protected $studentService;
    protected $profileService;

    public function __construct(StudentService $studentService, ProfileService $profileService)
    {
        $this->studentService = $studentService;
        $this->profileService = $profileService;
    }

    public function index()
    {
        $login = Auth::user();
        $profiles = $this->profileService->getAllProfilesfirst();
        // dd($profiles);
        if ($login->role == 'superadmin') {
            return view('Superadmin.Siswa.index', compact('profiles'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Siswa.index', compact('profiles')); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    // public function list(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $statusVote = $request->get('status_vote'); // Get the status_vote from the request
    //         $data = $this->studentService->getStudentsWithStatusVoteFilter($statusVote);

    //         return DataTables::of($data)
    //             ->addColumn('status_vote', function ($row) {
    //                 if ($row->StatusVote) {
    //                     return '<span class="badge bg-success">Sudah Memilih</span>';
    //                 } else {
    //                     return '<span class="badge bg-danger">Belum Memilih</span>';
    //                 }
    //             })
    //             ->rawColumns(['status_vote'])
    //             ->addIndexColumn()
    //             ->make(true);
    //     }
    //     return response()->json(['message' => 'Method not allowed'], 405);
    // }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $statusVote = $request->get('status_vote'); // Get the status_vote from the request
            $statusAccount = $request->get('status_account'); // Also get the status_account

            $data = $this->studentService->getStudentsWithStatusVoteFilter($request);

            return DataTables::of($data)
                ->addColumn('status_vote', function ($row) {
                    if ($row->StatusVote) {
                        return '<span class="badge bg-success">Sudah Memilih</span>';
                    } else {
                        return '<span class="badge bg-danger">Belum Memilih</span>';
                    }
                })
                ->rawColumns(['status_vote'])
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(['message' => 'Method not allowed'], 405);
    }



    public function create()
    {
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.Siswa.create');
        } elseif ($login->role == 'admin') {
            return view('Admin.Siswa.create'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function store(StoreStudentRequest $request)
    {
        $result = $this->studentService->createStudentAndUser($request);
        // dd($result);  // Ensure this line is reached

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('students.admin.index')->with('success', 'Mahasiswa berhasil ditambahkan.'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function show($uuid)
    {
        $student = $this->studentService->findStudentByUUID($uuid);

        // Check if student exists
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Siswa tidak ditemukan.');
        }
        $periode = Periode::where('actif', 1)->first();
        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Siswa.detail', compact('student', 'periode'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Siswa.detail', compact('student', 'periode')); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function edit($uuid)
    {
        $student = $this->studentService->findStudentByUUID($uuid);
        if (!$student) {
            abort(404);
        }
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return view('Superadmin.Siswa.edit', compact('student'));
        } elseif ($login->role == 'admin') {
            return view('Admin.Siswa.edit', compact('student')); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function update(UpdateStudentRequest $request, $uuid)
    {
        $result = $this->studentService->updateStudentAndUser($request, $uuid);
        // dd($result);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('students.index')->with('success', 'Data mahasiswa dan pengguna berhasil diperbarui.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('students.admin.index')->with('success', 'Data mahasiswa dan pengguna berhasil diperbarui.'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroy($uuid)
    {
        $this->studentService->deleteStudentAndUser($uuid);
        return redirect()->back()->with('success', 'Mahasiswa dan pengguna berhasil dihapus.');
    }

    public function reportPemilih()
    {
        $data = $this->studentService->getStudentsWithStatusVote();
        // dd($data);
        $profiles = $this->profileService->getAllProfilesfirst();
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            $pdf = Pdf::loadView('Superadmin.Siswa.cetak_pdf', [
                'profiles' => $profiles,
                'data' => $data,
            ]);
            return $pdf->stream();
        } elseif ($login->role == 'admin') {
            $pdf = Pdf::loadView('Admin.Siswa.cetak_pdf', [
                'profiles' => $profiles,
                'data' => $data,
            ]);
            return $pdf->stream();
        } else {
            abort(403, 'Unauthorized action.');
        }

        return $pdf->stream();
    }

    public function importDataStudent(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file' => 'required|mimes:xls,xlsx'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'stat'     => false,
                    'msg'      => 'Terjadi kesalahan.',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file');
            $nama_file = rand() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/temp_import'), $nama_file);

            try {
                $collection = Excel::toCollection(new StudentImport, public_path('assets/temp_import/' . $nama_file));
                $collection = $collection[0];

                $collection->each(function ($item) {
                    // Periksa apakah ada data yang valid untuk username dan nama
                    if (!empty($item[1]) && !empty($item[2])) {
                        $data = [
                            'nis' => $item[0],    // Ini untuk User dan Student
                            'nama' => $item[1],   // Ini untuk Student
                            'kelas' => $item[2],
                            'jenis_kelamin' => $item[3],
                            'status_students' => 1, // Default status students
                            'name' => $item[4]    // Ini untuk User
                        ];

                        // Panggil metode createStudentAndUser dengan data array
                        $result = $this->studentService->createStudentAndUser(new Request($data));

                        if (isset($result['error'])) {
                            throw new \Exception($result['error']);
                        }
                    }
                });

                unlink(public_path('assets/temp_import/' . $nama_file)); // Hapus file setelah selesai

                return response()->json([
                    'stat' => true,
                    'mc' => true, // close modal
                    'msg' => 'Data berhasil diimport'
                ]);
            } catch (\Exception $e) {
                unlink(public_path('assets/temp_import/' . $nama_file)); // Hapus file jika terjadi kesalahan

                Log::error('Import Error: ' . $e->getMessage());

                return response()->json([
                    'stat' => false,
                    'msg' => 'Terjadi kesalahan selama proses impor.',
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
