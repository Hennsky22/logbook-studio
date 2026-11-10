<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistKeteranganHarian extends Model
{
    protected $fillable = [
    'user_id',
    'studio',
    'tanggal',
    'keterangan',
    'foto_tanda_tangan',
    'waktu_submit',
];

protected $casts = [
    'tanggal' => 'date',
    'waktu_submit' => 'datetime',
];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
