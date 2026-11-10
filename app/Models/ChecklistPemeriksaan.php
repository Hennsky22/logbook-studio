<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'checklist_pemeriksaans';

    protected $fillable = [
        'user_id',
        'item_id',
        'tanggal_pemeriksaan',
        'kondisi',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
