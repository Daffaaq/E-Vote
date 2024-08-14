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
        $periodeActiveId = DB::table('periode')->insertGetId([
            'uuid' => Str::uuid(),
            'periode_nama' => '2024-2025',
            'periode_kepala_sekolah' => 'David Oroza',
            'periode_no_kepala_sekolah' => '70003331',
            'actif' => 1, // aktif
            'created_at' => now(),
            'updated_at' => now(),
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
                'name_events' => 'E-Vote',
                'nickname_profiles' => 'SCBIS',
                'name_profiles' => 'Student Council Brillantmont International School',
                'address_profiles' => 'Avenue Charles-Secrétan 16 · 1005 Lausanne, Switzerland',
                'phone_profiles' => '+4121 310 0400',
                'email_profiles' => 'info@brillantmont.ch',
                'description_profiles' => 'The Student Council at Brillantmont International School is a student body that represents the voices and aspirations of the students in various aspects of school life. They are responsible for organizing events and activities, coordinating social, charity, and extracurricular activities, and collaborating with the school staff to enhance the overall student experience.',
                'twitter_url' => 'https://twitter.com/',
                'facebook_url' => 'https://www.facebook.com/Brillantmont',
                'instagram_url' => 'https://www.instagram.com/brillantmont_is/',
                'linkedin_url' => 'https://ch.linkedin.com/school/brillantmont-international-school/',
                'line_url' => 'https://line.me/ti/p/',
                'tiktok_url' => 'https://tiktok.com/',
                'youtube_url' => 'https://www.youtube.com/@brillantmontinternationals9379',
                'threads_url' => 'https://www.threads.net/',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan lebih banyak data jika perlu
        ]);

        DB::table('jadwal_votes')->insert([
            [
                'uuid' => Str::uuid(),
                'periode_id' => 1, // Assuming this relates to an existing periode
                'tanggal_awal_vote' => '2024-08-01',
                'tanggal_akhir_vote' => '2024-08-07',
                'tempat_vote' => 'Aula Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder for jadwal_orasis table
        DB::table('jadwal_orasis')->insert([
            [
                'uuid' => Str::uuid(),
                'periode_id' => 1,
                'tanggal_orasi_vote' => '2024-07-25',
                'jam_orasi_mulai' => '09:00:00',
                'tempat_orasi' => 'Lapangan Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder for jadwal_result_votes table
        DB::table('jadwal_result_votes')->insert([
            [
                'uuid' => Str::uuid(),
                'periode_id' => $periodeActiveId,
                'tanggal_result_vote' => '2024-08-08',
                'jam_result_vote' => '15:00:00',
                'tempat_result_vote' => 'Aula Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
