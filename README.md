# E-Vote Project

E-Vote adalah sistem pemungutan suara digital yang dirancang untuk digunakan oleh berbagai organisasi, seperti OSIS dan komunitas lainnya. Proyek ini dibangun menggunakan Laravel dan Maze Dashboard, serta menerapkan pola Repository dan Service untuk arsitektur yang bersih dan terstruktur.

## Fitur

-   **CRUD Periode**: Mengelola periode pemungutan suara yang berbeda.
-   **CRUD Profile**: Menyimpan dan mengelola profil organisasi atau OSIS.
-   **CRUD Jadwal**: Menyusun jadwal orasi, jadwal voting, dan jadwal pembacaan hasil.
-   **CRUD Kandidat**: Mengelola informasi kandidat, termasuk ketua dan wakil ketua.
-   **CRUD Pemilih**: Mengelola data pemilih yang berpartisipasi dalam pemungutan suara.
-   **Aspirasi di Halaman Guest**: Memungkinkan pemilih untuk memberikan aspirasi atau masukan di halaman tamu.
-   **Kontrol Voting**: Membuka dan menutup voting kapan saja serta pengaturan status voting.

## Teknologi

-   **Laravel**: Framework PHP untuk pengembangan aplikasi web.
-   **Maze Dashboard**: Dashboard yang digunakan untuk antarmuka pengguna.
-   **Repository Pattern**: Pola arsitektur untuk pengelolaan data.
-   **Service Pattern**: Pola arsitektur untuk pemisahan logika bisnis dari lapisan akses data.

## Instalasi

1. Clone repository ini:

    ```bash
    git clone https://github.com/username/e-vote.git
    ```

2. Install Dependencies:

    ```
    cd e-vote
    composer install
    npm install

    ```

3. Konfigurasi .env: Salin file .env.example menjadi .env dan sesuaikan konfigurasi database dan pengaturan lainnya.
    ```
    cp .env.example .env
    ```
4. Generate Key:
    ```
    php artisan key:generate
    ```
5. Migrate Database:
    ```
    php artisan migrate
    ```
6. Seed Database (Opsional):
    ```
    php artisan db:seed
    ```
7. Jalankan Aplikasi:
    ```
    php artisan serve
    ```

## Lisensi
    silahkan kalau mau pakai E-Votenya ini, silahkan diperbaiki sendiri yaa 🤣🤣🤣 kalau ada bug saya males nge QA 🤣🤣