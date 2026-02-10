<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggapanAduan extends Model
{
    use HasFactory;

    protected $table = 'tanggapan_aduan';
    public $timestamps = false;

    protected $fillable = [
        'aduan_id',
        'keterangan',
        'tanggal_tanggapan',
    ];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    /**
     * Relasi Many-to-One dengan Aduan
     */
    public function aduan()
    {
        return $this->belongsTo(Aduan::class, 'aduan_id');
    }
}
