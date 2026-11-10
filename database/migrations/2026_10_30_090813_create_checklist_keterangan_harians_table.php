<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checklist_keterangan_harians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('studio');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(
                ['studio', 'tanggal'],
                'studio_tanggal_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_keterangan_harians');
    }
};