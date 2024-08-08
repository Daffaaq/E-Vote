<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'uuid' => Str::uuid(),
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'foto_profile' => null,
            'role' => 'superadmin',
            'password' => Hash::make('superadminpassword'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan pengguna dengan role admin
        $adminId = DB::table('users')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Admin',
            'username' => 'admin',
            'foto_profile' => null,
            'role' => 'admin',
            'password' => Hash::make('adminpassword'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan pengguna dengan role voter
        $voterId1 = DB::table('users')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Faza',
            'username' => '11223344',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword1'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $voterId2 = DB::table('users')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Sindiana',
            'username' => '44332211',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $voterId3 = DB::table('users')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Nayla',
            'username' => '44332219',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $voterId4 = DB::table('users')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Syamsul',
            'username' => '44332218',
            'foto_profile' => null,
            'role' => 'voter',
            'password' => Hash::make('voterpassword2'), // Ganti dengan password yang lebih aman
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data siswa yang terhubung dengan pengguna voter
        DB::table('students')->insert([
            [
                'uuid' => Str::uuid(),
                'nama' => 'Faza Rahardian',
                'nis' => '11223344',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'Laki-laki',
                'status_students' => 1,
                'users_id' => $voterId1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Sindiana Karim',
                'nis' => '44332211',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'Perempuan',
                'status_students' => 1,
                'users_id' => $voterId2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Queen Nayla',
                'nis' => '44332219',
                'kelas' => 'VII C',
                'jenis_kelamin' => 'Perempuan',
                'status_students' => 1,
                'users_id' => $voterId3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'nama' => 'Muhammad Syamsul Arifin',
                'nis' => '44332218',
                'kelas' => 'VII D',
                'jenis_kelamin' => 'Laki-laki',
                'status_students' => 1,
                'users_id' => $voterId4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tambahkan periode
        DB::table('periode')->insert([
            [
                'uuid' => Str::uuid(),
                'periode_nama' => '2024-2025',
                'periode_kepala_sekolah' => 'David Oroza',
                'periode_no_kepala_sekolah' => '70003331',
                'actif' => 1, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => Str::uuid(),
                'periode_nama' => '2025-2026',
                'periode_kepala_sekolah' => 'David Oroza',
                'periode_no_kepala_sekolah' => '70003331',
                'actif' => 2, // aktif
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('setting_vote')->insert([
            [
                'uuid' => Str::uuid(),
                'set_vote' => true,
            ]
        ]);

        DB::table('profiles')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'nickname_profiles' => 'HMK',
                'name_profiles' => 'Himpunan Mahasiswa Konoha',
                'address_profiles' => '123 Elm Street, Springfield',
                'phone_profiles' => '555-1234',
                'email_profiles' => 'hmk@gmail.com',
                'description_profiles' => 'Himpunana Mahasiswa Konoha berada di Springfield.',
                'twitter_url' => 'https://twitter.com/',
                'facebook_url' => 'https://facebook.com/',
                'instagram_url' => 'https://instagram.com/',
                'linkedin_url' => 'https://linkedin.com/in/',
                'line_url' => 'https://line.me/ti/p/',
                'tiktok_url' => 'https://tiktok.com/',
                'youtube_url' => 'https://youtube.com/c/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan lebih banyak data jika perlu
        ]);
    }
}
