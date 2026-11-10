<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_crew_harians', function (Blueprint $table) {
            $table->id();

            $table->string('studio', 100);

            $table->date('tanggal');

            $table->string('nama_crew', 100);

            $table->text('keterangan')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Satu crew hanya memiliki satu data
            // untuk setiap studio dan tanggal.
            $table->unique(
                ['studio', 'tanggal', 'nama_crew'],
                'crew_studio_tanggal_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_crew_harians');
    }
};
