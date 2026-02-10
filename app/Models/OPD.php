<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OPD extends Model
{
    /**
     * Relasi One-to-Many dengan UnitOpd
     */
    public function unitOpds()
    {
        return $this->hasMany(UnitOpd::class, 'opd_id');
    }
    use HasFactory;

    protected $table = 'opd';
    public $timestamps = false;

    protected $fillable = [
        'nama_opd',
        'no_telp',
        'alamat',
    ];

    /**
     * Relasi Many-to-Many dengan Pengguna
     */
    public function pengguna()
    {
        return $this->belongsToMany(Pengguna::class, 'opd_pengguna', 'opd_id', 'pengguna_id');
    }

    /**
     * Relasi Many-to-Many dengan KategoriAduan
     */
    public function kategoriAduan()
    {
        return $this->belongsToMany(KategoriAduan::class, 'kategori_aduan_opd', 'opd_id', 'kategori_aduan_id');
    }
}
