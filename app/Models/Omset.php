<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Omset extends Model
{
    use HasFactory;

    protected $table = 'omset';

    protected $fillable = [
        'biaya',
        'tanggal_omset',
    ];
}
