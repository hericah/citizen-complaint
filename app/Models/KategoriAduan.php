<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAduan extends Model
{
    use HasFactory;

    protected $table = 'kategori_aduan';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_dibuat' => 'datetime',
        'tanggal_diubah' => 'datetime',
    ];

    /**
     * Relasi Many-to-Many dengan OPD
     */
    public function opd()
    {
        return $this->belongsToMany(OPD::class, 'kategori_aduan_opd', 'kategori_aduan_id', 'opd_id');
    }

    /**
     * Relasi One-to-Many dengan Aduan
     */
    public function aduan()
    {
        return $this->hasMany(Aduan::class, 'kategori_aduan_id');
    }
}
