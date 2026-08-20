<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materi;
use App\Models\Kuis;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moduls = ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing'];

        foreach ($moduls as $modul) {
            // Generate 10 Materi for each module
            for ($i = 1; $i <= 10; $i++) {
                Materi::create([
                    'nama_modul' => $modul,
                    'judul'      => "Materi Ke-$i: Dasar-dasar $modul",
                    'deskripsi'  => "Ini adalah deskripsi dummy untuk materi $i pada modul $modul. Materi ini mencakup pengenalan konsep dasar, fungsi utama, dan cara kerja perangkat $modul dalam jaringan Fiber To The Home (FTTH). Harap pelajari dengan seksama untuk persiapan kuis.",
                    'url_video'  => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Dummy video link
                    'urutan'     => $i,
                ]);
            }

            // Generate 10 Kuis for each module
            $options = ['A', 'B', 'C', 'D'];
            for ($i = 1; $i <= 10; $i++) {
                Kuis::create([
                    'nama_modul'    => $modul,
                    'pertanyaan'    => "Pertanyaan Ke-$i untuk pengujian kompetensi pada modul $modul adalah...?",
                    'opsi_a'        => "Pilihan A untuk $modul soal $i",
                    'opsi_b'        => "Pilihan B untuk $modul soal $i",
                    'opsi_c'        => "Pilihan C untuk $modul soal $i",
                    'opsi_d'        => "Pilihan D untuk $modul soal $i",
                    'jawaban_benar' => $options[array_rand($options)],
                ]);
            }
        }
    }
}
