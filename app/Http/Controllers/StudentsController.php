<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StudentsController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index()
    {
        $login = Auth::user();

        if ($login->role == 'superadmin') {
            return view('Superadmin.Siswa.index');
        } elseif ($login->role == 'admin') {
            return view('Superadmin.Siswa.index1'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->studentService->getStudentsWithStatusVote();
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
            return view('Superadmin.Siswa.create1'); // belum fix view
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
            return redirect()->route('students.index1')->with('success', 'Mahasiswa berhasil ditambahkan.'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }


    public function show($id)
    {
        $student = $this->studentService->findStudentByUUID($id);
        return view('students.show', compact('student'));
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
            return view('Superadmin.Siswa.edit1', compact('student')); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
        return view('Superadmin.Siswa.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, $uuid)
    {
        $result = $this->studentService->updateStudentAndUser($request, $uuid);
        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }
        $login = Auth::user();
        if ($login->role == 'superadmin') {
            return redirect()->route('students.index')->with('success', 'Data mahasiswa dan pengguna berhasil diperbarui.');
        } elseif ($login->role == 'admin') {
            return redirect()->route('students.index1')->with('success', 'Data mahasiswa dan pengguna berhasil diperbarui.'); // belum fix view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function destroy($uuid)
    {
        $this->studentService->deleteStudentAndUser($uuid);
        return redirect()->back()->with('success', 'Mahasiswa dan pengguna berhasil dihapus.');
    }
}
