<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laba extends Model
{
    use HasFactory;

    protected $table = 'laba';

    protected $fillable = [
        'biaya',
        'tanggal_laba',
    ];
}
