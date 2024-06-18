<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;

    protected $table = 'marketing';

    protected $fillable = [
        'kategori',
        'kode',
        'keterangan',
        'biaya',
        'biaya_bulan',
        'total_biaya',
        'tanggal_marketing',
    ];
}
