<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $fillable = [
        'user_id',
        'studio',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'jenis_kegiatan',
        'nama_kegiatan',
        'uraian_kegiatan',
        'petugas',
        'kendala',
        'penyebab',
        'penanganan',
        'kondisi_akhir',
        'nama_pelapor',
        'foto',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }
}
