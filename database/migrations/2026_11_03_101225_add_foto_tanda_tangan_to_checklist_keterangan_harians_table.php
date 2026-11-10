<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checklist_keterangan_harians', function (Blueprint $table) {
            $table->string('foto_tanda_tangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('checklist_keterangan_harians', function (Blueprint $table) {
            $table->dropColumn('foto_tanda_tangan');
        });
    }
};