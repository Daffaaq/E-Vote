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
        $query = Students::query();

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
        return view('Superadmin.Siswa.index', compact('data'));
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

    public function edit($id)
    {
        $student = Students::findOrFail($id);
        return view('Superadmin.Siswa.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string',
            'nis' => 'required|string|unique:students,nis,' . $id,
            'kelas' => 'required|string',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'status_students' => 'required|integer|in:1,2',
        ]);

        // Perbarui data mahasiswa
        $student = Students::findOrFail($id);
        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus data mahasiswa
        $student = Students::findOrFail($id);
        $student->delete();

        // Hapus juga user terkait jika ada
        $user = User::where('username', $student->nis)->first();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
