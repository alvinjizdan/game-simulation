# ViberLink LMS 🚀

ViberLink LMS (Learning Management System) adalah platform pembelajaran interaktif yang dirancang khusus untuk melatih dan menguji kemampuan Teknisi jaringan *Fiber To The Home* (FTTH). Platform ini menyediakan materi pembelajaran komprehensif, evaluasi kuis, serta simulasi praktik perancangan jaringan optik.

Sistem ini dibangun sebagai pemenuhan tugas akhir (Skripsi) untuk memfasilitasi pembelajaran praktis teknisi fiber optik secara terstruktur dan terukur.

## Fitur Utama

### Mode Peserta (Teknisi)
- **Dashboard Pembelajaran Interaktif**: Melacak progres pembelajaran dengan indikator visual dan daftar modul yang tertata rapi.
- **5 Modul Inti FTTH**:
  - Modul OLT (Optical Line Terminal)
  - Modul ODC (Optical Distribution Cabinet)
  - Modul ODP (Optical Distribution Point)
  - Modul ONT (Optical Network Terminal)
  - Modul Splicing (Penyambungan Kabel Optik)
- **Evaluasi Kuis**: Sistem kuis pilihan ganda dengan penilaian otomatis dan pencatatan skor tertinggi.
- **Simulasi Praktik Jaringan (LPB)**: Fitur kalkulasi Link Power Budget (LPB) untuk menghitung kelayakan redaman jaringan fiber optik (Loss & Rx Daya Terima).
- **Katalog Perangkat**: Menampilkan daftar dan spesifikasi perangkat jaringan optik standar.

### Mode Administrator
- **Rapor Peserta**: Dasbor analitik untuk memantau progres kelulusan semua teknisi (Total Peserta, Lulus, Belum Lulus).
- **Manajemen Peserta**: Menambahkan, mengedit, dan menghapus akun teknisi.
- **Manajemen Materi & Topik**: Mengelola konten teks, gambar, dan video pembelajaran untuk tiap modul.
- **Manajemen Kuis**: Membuat dan menyusun bank soal pilihan ganda untuk setiap modul.

## Teknologi yang Digunakan

- **Framework Backend**: [Laravel 10](https://laravel.com/) (PHP)
- **Database**: MySQL
- **Desain UI/UX**: Vanilla CSS dengan variabel kustom (mengadopsi sistem desain *Light Mode*, *Glassmorphism*).
- **Ikon**: [Lucide Icons](https://lucide.dev/)
- **Arsitektur**: Model-View-Controller (MVC)

## Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan ViberLink LMS di komputer lokal Anda.

### Prasyarat:
- PHP >= 8.1
- Composer
- MySQL Server (XAMPP / Laragon / dll)

### Langkah Instalasi:

1. **Clone repositori ini**
   `ash
   git clone https://github.com/username-anda/viberlink-app.git
   cd viberlink-app
   `

2. **Install dependensi PHP**
   `ash
   composer install
   `

3. **Konfigurasi Environment**
   Salin file .env.example menjadi .env
   `ash
   cp .env.example .env
   `
   Buka file .env dan sesuaikan konfigurasi database Anda:
   `env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=viberlink_db
   DB_USERNAME=root
   DB_PASSWORD=
   `

4. **Generate Application Key**
   `ash
   php artisan key:generate
   `

5. **Jalankan Migrasi & Seeder Database** (Untuk membuat tabel dan data awal)
   `ash
   php artisan migrate --seed
   `

6. **Jalankan Server Lokal Laravel**
   `ash
   php artisan serve
   `
   Aplikasi kini dapat diakses melalui browser di alamat: http://localhost:8000

## Hak Akses (Role)

Secara default, sistem memisahkan pengalaman pengguna berdasarkan otorisasi (*role*):

1. **Admin**
   - Akses penuh ke ruang tata kelola (Dashboard Admin).
   - Mampu mengelola data master (Materi, Kuis, Pengguna).
   
2. **Peserta (Teknisi)**
   - Akses ke ruang pembelajaran interaktif (Dashboard Teknisi).
   - Dapat mengerjakan kuis, membaca materi, dan melakukan simulasi.

## UI & Sistem Desain
Aplikasi ini dikembangkan menggunakan **Vanilla CSS (style.css)** dengan memanfaatkan *CSS Variables* untuk menciptakan desain komponen yang bersih, minimalis, dengan garis warna tegas (merah, kuning, hijau) untuk menandai berbagai kategori modul secara visual, membuat proses belajar lebih intuitif.

## Lisensi
Hak Cipta &copy; 2026. Aplikasi ini dibangun untuk keperluan edukasi dan tugas akhir akademik.
