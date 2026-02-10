<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesAduan extends Model
{
    use HasFactory;

    protected $table = 'akses_aduan';
    public $timestamps = false;

    protected $fillable = [
        'nama_akses_aduan',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_diubah' => 'datetime',
    ];
}
