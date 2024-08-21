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

        // Tambahkan data siswa yang terhubung dengan pengguna voter
        // Array data pengguna voter
        $voters = [
            [
                'name' => 'Faza',
                'username' => '11223344',
                'password' => 'voterpassword1',
                'student_name' => 'Faza Rahardian',
                'nis' => '11223344',
                'kelas' => 'VII A',
                'jenis_kelamin' => 'Laki-laki',
            ],
            [
                'name' => 'Sindiana',
                'username' => '44332211',
                'password' => 'voterpassword2',
                'student_name' => 'Sindiana Karim',
                'nis' => '44332211',
                'kelas' => 'VII B',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Nayla',
                'username' => '44332219',
                'password' => 'voterpassword3',
                'student_name' => 'Queen Nayla',
                'nis' => '44332219',
                'kelas' => 'VII C',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Syamsul',
                'username' => '44332218',
                'password' => 'voterpassword4',
                'student_name' => 'Muhammad Syamsul Arifin',
                'nis' => '44332218',
                'kelas' => 'VII D',
                'jenis_kelamin' => 'Laki-laki',
            ],
            // Tambahkan data tambahan di sini
            [
                'name' => 'Dani',
                'username' => '55443322',
                'password' => 'voterpassword5',
                'student_name' => 'Dani Santoso',
                'nis' => '55443322',
                'kelas' => 'VII E',
                'jenis_kelamin' => 'Laki-laki',
            ],
            [
                'name' => 'Rahma',
                'username' => '66554433',
                'password' => 'voterpassword6',
                'student_name' => 'Rahma Aulia',
                'nis' => '66554433',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Nahla',
                'username' => '66554434',
                'password' => 'voterpassword7',
                'student_name' => 'Nahla Aulia',
                'nis' => '66554434',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Nadiya',
                'username' => '66554435',
                'password' => 'voterpassword8',
                'student_name' => 'Nadiya Aulia',
                'nis' => '66554435',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Balqis',
                'username' => '66554436',
                'password' => 'voterpassword9',
                'student_name' => 'Balqis Aulia',
                'nis' => '66554436',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Siti',
                'username' => '66554437',
                'password' => 'voterpassword10',
                'student_name' => 'Siti Aulia',
                'nis' => '66554437',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Dini',
                'username' => '66554438',
                'password' => 'voterpassword11',
                'student_name' => 'Dini Aulia',
                'nis' => '66554438',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            [
                'name' => 'Rayza',
                'username' => '66554439',
                'password' => 'voterpassword12',
                'student_name' => 'Rayza Aulia',
                'nis' => '66554439',
                'kelas' => 'VII F',
                'jenis_kelamin' => 'Perempuan',
            ],
            // Tambahkan lebih banyak data lagi sesuai kebutuhan
        ];


        foreach ($voters as $voter) {
            $voterId = DB::table('users')->insertGetId([
                'uuid' => Str::uuid(),
                'name' => $voter['name'],
                'username' => $voter['username'],
                'foto_profile' => null,
                'role' => 'voter',
                'password' => Hash::make($voter['password']), // Ganti dengan password yang lebih aman
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('students')->insert([
                'uuid' => Str::uuid(),
                'nama' => $voter['student_name'],
                'nis' => $voter['nis'],
                'kelas' => $voter['kelas'],
                'jenis_kelamin' => $voter['jenis_kelamin'],
                'status_students' => 1,
                'users_id' => $voterId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


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
                'nickname_profiles' => 'SCKIS',
                'name_profiles' => 'Student Council Konoha International School',
                'address_profiles' => 'Endless Traffic Street 16 · 1005 Konoha, Konohamasila',
                'phone_profiles' => '+4121 310 04100',
                'email_profiles' => 'info@Konoha.ch',
                'description_profiles' => 'The Student Council Konoha International School is a student body that represents the voices and aspirations of the students in various aspects of school life. They are responsible for organizing events and activities, coordinating social, charity, and extracurricular activities, and collaborating with the school staff to enhance the overall student experience.',
                'twitter_url' => 'https://twitter.com/',
                'facebook_url' => 'https://www.facebook.com/Konoha',
                'instagram_url' => 'https://www.instagram.com/konoha_is/',
                'linkedin_url' => 'https://ch.linkedin.com/school/konoha-international-school/',
                'line_url' => 'https://line.me/ti/p/',
                'tiktok_url' => 'https://tiktok.com/',
                'youtube_url' => 'https://www.youtube.com/@konohainternationals9379',
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
