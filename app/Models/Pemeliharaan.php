<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pemeliharaan extends Model
{
    protected $table = 'pemeliharaan';

    protected $fillable = [
        'item_id',
        'tanggal_rusak',
        'tanggal_perbaikan',
        'kerusakan',
        'penanganan',
        'foto_awal',
        'foto_sesudah',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_rusak' => 'date',
            'tanggal_perbaikan' => 'date',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
