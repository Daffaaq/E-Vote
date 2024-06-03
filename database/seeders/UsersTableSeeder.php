<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan pengguna dengan role superadmin
        $superadminId = DB::table('users')->insertGetId([
            'username' => 'superadmin',
            'foto_profile' => null,
            'role' => 'superadmin',
            'password' => Hash::make('superadminpassword'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan pengguna dengan role admin
        $adminId = DB::table('users')->insertGetId([
            'username' => 'admin',
            'foto_profile' => null,
            'role' => 'admin',
            'password' => Hash::make('adminpassword'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan pengguna dengan role voter
        $voterId1 = DB::table('users')->insertGetId([
            'username' => 'Student 1',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword1'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $voterId2 = DB::table('users')->insertGetId([
            'username' => 'Student 2',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $voterId2 = DB::table('users')->insertGetId([
            'username' => 'Student 3',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $voterId2 = DB::table('users')->insertGetId([
            'username' => 'Student 4',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data siswa yang terhubung dengan pengguna voter
        DB::table('students')->insert([
            [
                'nama' => 'Student 1',
                'nis' => '11223344',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'Laki-laki',
                'status_students' => 1,
                'users_id' => $voterId1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Student 2',
                'nis' => '44332211',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'Perempuan',
                'status_students' => 1,
                'users_id' => $voterId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Student 3',
                'nis' => '44332219',
                'kelas' => 'VII C',
                'jenis_kelamin' => 'Perempuan',
                'status_students' => 1,
                'users_id' => $voterId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Student 4',
                'nis' => '44332218',
                'kelas' => 'VII D',
                'jenis_kelamin' => 'Laki-laki',
                'status_students' => 1,
                'users_id' => $voterId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tambahkan periode
        DB::table('periode')->insert([
            [
                'periode_nama' => '2024-2025',
                'periode_kepala_sekolah' => 'Habibi Dinil Haq',
                'periode_no_kepala_sekolah' => '70003331',
                'actif' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'periode_nama' => '2025-2026',
                'periode_kepala_sekolah' => 'Habibi Dinil Haq',
                'periode_no_kepala_sekolah' => '70003331',
                'actif' => 2, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
