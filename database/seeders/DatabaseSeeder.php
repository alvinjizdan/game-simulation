<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use App\Models\PerangkatFtth;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Admin
        Pengguna::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'nama_lengkap' => 'Administrator',
            'role' => 'Admin'
        ]);

        // Seed Contoh Peserta
        $peserta = Pengguna::create([
            'username' => 'teknisi',
            'password' => Hash::make('teknisi123'),
            'nama_lengkap' => 'Budi Santoso',
            'role' => 'Peserta'
        ]);

        $moduls = ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing'];
        foreach ($moduls as $modul) {
            \App\Models\ProgressModul::create([
                'id_user' => $peserta->id_user,
                'nama_modul' => $modul
            ]);
        }

        // 2. Seed Perangkat FTTH (Sesuai Urutan Jaringan)
        $perangkat = [
            [
                'nama_perangkat' => 'Optical Line Terminal (OLT)',
                'tipe_perangkat' => 'OLT',
                'deskripsi_lengkap' => 'Titik awal jaringan FTTH yang berada di sentral provider. OLT mengubah sinyal listrik menjadi sinyal optik.',
                'fungsi_utama' => 'Mengirim dan menerima sinyal optik dari dan ke jaringan distribusi.',
                'urutan' => 1
            ],
            [
                'nama_perangkat' => 'Kabel Feeder',
                'tipe_perangkat' => 'Kabel Optik',
                'deskripsi_lengkap' => 'Kabel fiber optik utama yang keluar dari sentral (OLT) dan mendistribusikan kapasitas besar ke titik percabangan.',
                'fungsi_utama' => 'Sebagai jalur utama pengiriman sinyal dari sentral.',
                'urutan' => 2
            ],
            [
                'nama_perangkat' => 'Optical Distribution Cabinet (ODC)',
                'tipe_perangkat' => 'ODC',
                'deskripsi_lengkap' => 'Lemari distribusi optik yang biasanya berada di pinggir jalan. Di dalamnya terdapat splitter pertama.',
                'fungsi_utama' => 'Membagi satu core dari kabel feeder menjadi beberapa core untuk kabel distribusi.',
                'urutan' => 3
            ],
            [
                'nama_perangkat' => 'Kabel Distribusi',
                'tipe_perangkat' => 'Kabel Optik',
                'deskripsi_lengkap' => 'Kabel yang menghubungkan ODC dengan ODP di area perumahan.',
                'fungsi_utama' => 'Menyalurkan sinyal optik dari ODC menuju titik terdekat dengan pelanggan.',
                'urutan' => 4
            ],
            [
                'nama_perangkat' => 'Optical Distribution Point (ODP)',
                'tipe_perangkat' => 'ODP',
                'deskripsi_lengkap' => 'Kotak terminal yang berada di tiang listrik atau dinding rumah. Ini adalah titik percabangan terakhir sebelum ke rumah pelanggan.',
                'fungsi_utama' => 'Tempat terminasi kabel distribusi dan titik penyambungan ke kabel drop.',
                'urutan' => 5
            ],
            [
                'nama_perangkat' => 'Drop Core',
                'tipe_perangkat' => 'Kabel Drop',
                'deskripsi_lengkap' => 'Kabel fiber optik kecil (biasanya hitam) yang ditarik dari tiang (ODP) langsung ke dalam rumah pelanggan.',
                'fungsi_utama' => 'Menghubungkan ODP dengan Roset Optik di rumah pelanggan.',
                'urutan' => 6
            ],
            [
                'nama_perangkat' => 'Optical Network Terminal (ONT)',
                'tipe_perangkat' => 'ONT / Modem',
                'deskripsi_lengkap' => 'Perangkat yang dipasang di dalam rumah pelanggan (sering disebut modem).',
                'fungsi_utama' => 'Mengubah sinyal optik kembali menjadi sinyal listrik/digital (Ethernet, Wi-Fi) untuk digunakan oleh pelanggan.',
                'urutan' => 7
            ]
        ];

        foreach ($perangkat as $p) {
            PerangkatFtth::create($p);
        }
    }
}
