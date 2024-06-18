<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operasional extends Model
{
    use HasFactory;

    protected $table = 'operasional';

    protected $fillable = [
        'kategori',
        'keterangan',
        'biaya',
        'qty',
        'jumlah',
        'biaya_bulan',
        'total_biaya',
        'tanggal_operasional',
    ];

}