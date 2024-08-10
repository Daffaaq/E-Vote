<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentsController extends Controller
{
    public function index(Request $request)
    {
        // Set the number of items per page, default to 20 if not provided
        $perPage = $request->input('perPage', 20);

        // Initialize the query
        $query = Students::with('StatusVote');

        // Apply the status filter if provided
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == '1' || $status == '2') {
                $query->where('status_students', $status);
            }
        }

        // Apply the search filter if provided
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'LIKE', '%' . $search . '%')
                    ->orWhere('nis', 'LIKE', '%' . $search . '%')
                    ->orWhere('kelas', 'LIKE', '%' . $search . '%');
            });
        }

        // Select the necessary fields and paginate the results
        $data = $query->select(['id', 'nama', 'nis', 'kelas', 'status_students'])
            ->orderBy('nama', 'ASC')
            ->paginate($perPage)
            ->withQueryString();

        // Return the view with the data
        return view('Superadmin.Siswa.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Students::with('StatusVote')->select('id', 'uuid', 'nama', 'nis', 'kelas', 'status_students');
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
        return view('Superadmin.Siswa.create');
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students',
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_students' => 'required|integer|in:1,2',
        ]);

        // Buat pengguna baru dengan username dan password sesuai NIS
        $user = new User([
            'username' => $request->nis,
            'name' => $request->name,
            'password' => Hash::make($request->nis),
            'role' => 'voter', // Atur sesuai kebutuhan
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->save();

        // Simpan data mahasiswa baru
        $student = new Students([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'users_id' => $user->id, // menyimpan id pengguna yang baru dibuat
            'status_students' => $request->status_students,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $student->save();

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil ditambahkan.');
    }


    public function show($id)
    {
        $student = Students::findOrFail($id);
        return view('students.show', compact('student'));
    }

    public function edit($uuid)
    {
        $student = Students::where('uuid', $uuid)->firstOrFail();
        return view('Superadmin.Siswa.edit', compact('student'));
    }

    public function update(Request $request, $uuid)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis,' . $uuid . ',uuid',
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_students' => 'required|integer|in:1,2',
        ]);

        // Temukan data mahasiswa berdasarkan UUID
        $student = Students::where('uuid', $uuid)->firstOrFail();

        // Temukan data pengguna terkait berdasarkan users_id dari mahasiswa
        $user = User::where('id', $student->users_id)->firstOrFail();

        // Update data mahasiswa
        $student->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'status_students' => $request->status_students,
            'updated_at' => now(),
        ]);

        // Update data pengguna terkait
        $user->update([
            'username' => $request->nis,
            'name' => $request->name,
            'password' => Hash::make($request->nis), // Update the password
            'updated_at' => now(),
        ]);

        return redirect()->route('students.index')->with('success', 'Data mahasiswa dan pengguna berhasil diperbarui.');
    }

    public function destroy($uuid)
    {
        // Temukan data mahasiswa berdasarkan UUID
        $student = Students::where('uuid', $uuid)->firstOrFail();

        // Temukan data pengguna terkait berdasarkan nis dari mahasiswa
        $user = User::where('username', $student->nis)->first();

        // Hapus data mahasiswa
        $student->delete();

        // Hapus juga user terkait jika ada
        if ($user) {
            $user->delete();
        }

        return redirect()->back()->with('success', 'Mahasiswa dan pengguna berhasil dihapus.');
    }
}
