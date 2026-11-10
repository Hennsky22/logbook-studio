
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('studio');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('jenis_kegiatan');
            $table->string('nama_kegiatan');
            $table->text('uraian_kegiatan');
            $table->string('petugas');
            $table->text('kendala')->nullable();
            $table->text('penyebab')->nullable();
            $table->text('penanganan')->nullable();
            $table->string('kondisi_akhir')->nullable();
            $table->string('nama_pelapor')->nullable();
            $table->string('foto')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');

            $table->dropColumn([
                'studio',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
                'jenis_kegiatan',
                'nama_kegiatan',
                'uraian_kegiatan',
                'petugas',
                'kendala',
                'penyebab',
                'penanganan',
                'kondisi_akhir',
                'nama_pelapor',
                'foto',
            ]);
        });
    }
};
