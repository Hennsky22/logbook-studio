<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('checklist_keterangan_harians', function (Blueprint $table) {
            $table->dateTime('waktu_submit')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('checklist_keterangan_harians', function (Blueprint $table) {
            $table->dropColumn('waktu_submit');
        });
    }
};
