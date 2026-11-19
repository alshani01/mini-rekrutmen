<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique(); // Nomor registrasi unik pelamar
            $table->string('name');                      // Nama lengkap pelamar
            $table->string('position');                  // Posisi yang dilamar
            $table->string('unit_region')->nullable();   // Wilayah atau unit penempatan
            $table->enum('status', [
                'submitted',
                'reviewed',
                'accepted',
                'rejected',
            ])->default('submitted');
            $table->text('notes')->nullable();           // Catatan seleksi singkat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};