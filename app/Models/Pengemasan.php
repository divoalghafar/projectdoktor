<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengemasan extends Model
{
    use HasFactory;

    protected $table = 'pengemasan';

    protected $fillable = [
        'kategori',
        'keterangan',
        'ecommerce',
        'biaya',
        'qty',
        'jumlah',
        'biaya_bulan',
        'total_biaya',
        'tanggal_pengemasan',
    ];
}
