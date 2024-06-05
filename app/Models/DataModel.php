<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataModel extends Model
{
    use HasFactory;
    protected $table = 'manajemenresiko';

    protected $fillable = [
        'Tanggal Retur',
        'Nama Barang',
        'Jumlah',
        'Penyebab',
        'Status',
        'Keterangan',
    ];
}
