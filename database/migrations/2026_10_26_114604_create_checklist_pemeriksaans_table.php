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
    Schema::create('checklist_pemeriksaans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('item_id')
            ->constrained('items')
            ->cascadeOnDelete();   

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        $table->date('tanggal_pemeriksaan');
        $table->string('kondisi');
        $table->text('catatan')->nullable();

        $table->timestamps();

        $table->unique(
            ['item_id', 'tanggal_pemeriksaan'],
            'checklist_item_tanggal_unique'
        );
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist_pemeriksaans');
    }
};
