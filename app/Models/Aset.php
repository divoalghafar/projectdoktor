<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset';

    protected $fillable = [
        'kategori',
        'keterangan',
        'biaya',
        'qty',
        'jumlah',
        'tanggal_aset',

    ];
}
