<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('items', 'studio')) {
            Schema::table('items', function (Blueprint $table) {
                $table->string('studio')
                    ->default('Studio Master Control Room')
                    ->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('items', 'studio')) {
            Schema::table('items', function (Blueprint $table) {
                $table->dropColumn('studio');
            });
        }
    }
};
