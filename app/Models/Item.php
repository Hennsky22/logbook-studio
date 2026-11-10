<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $table = 'items';

   protected $fillable = [
    'nama_barang',
    'serial_number',
    'merk',
    'kategori',
    'foto',
    'tahun_produksi',
    'tahun_masuk',
    'status_barang',
    'kondisi_barang',
    'studio',
];

    public function pemeliharaans(): HasMany
    {
        return $this->hasMany(Pemeliharaan::class, 'item_id');
    }
}