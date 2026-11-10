
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('item_id')
                ->constrained('items')
                ->restrictOnDelete();

            $table->date('tanggal_rusak');
            $table->date('tanggal_perbaikan')->nullable();

            $table->text('kerusakan');
            $table->text('penanganan')->nullable();

            $table->string('foto_awal')->nullable();
            $table->string('foto_sesudah')->nullable();

            $table->string('status')->default('Menunggu Perbaikan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};
