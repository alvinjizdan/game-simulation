<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. PENGGUNA
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_lengkap')->nullable();
            $table->enum('role', ['Admin', 'Peserta'])->default('Peserta');
            $table->timestamps();
        });

        // 2. PERANGKAT FTTH
        Schema::create('perangkat_ftth', function (Blueprint $table) {
            $table->id('id_perangkat');
            $table->string('nama_perangkat');
            $table->string('tipe_perangkat')->nullable(); // e.g. OLT, ODC, dll
            $table->string('gambar_aset')->nullable();
            $table->text('deskripsi_lengkap')->nullable();
            $table->text('fungsi_utama')->nullable();
            $table->integer('urutan')->default(0); // Untuk urutan di game
            $table->timestamps();
        });

        // 3. PROGRESS MODUL (Pengganti Tugas Peserta statis)
        Schema::create('progress_modul', function (Blueprint $table) {
            $table->id('id_progress');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('pengguna')->onDelete('cascade');
            $table->enum('nama_modul', ['OLT', 'ODC', 'ODP', 'ONT', 'Splicing']);
            $table->enum('tingkat_kesulitan', ['Beginner', 'Intermediate', 'Expert'])->default('Beginner');
            $table->enum('status_tugas', ['Belum Selesai', 'Selesai'])->default('Belum Selesai');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down()
    {
        Schema::dropIfExists('progress_modul');
        Schema::dropIfExists('perangkat_ftth');
        Schema::dropIfExists('pengguna');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
    }
};
