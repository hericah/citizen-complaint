<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';
    public $timestamps = false;

    protected $fillable = [
        'nama_pengguna',
        'email',
        'password_hash',
        'status_verifikasi',
        'email_verifikasi',
        'token_verifikasi',
        'status_aktif',
    ];

    protected $casts = [
        'status_verifikasi' => 'boolean',
        'status_aktif' => 'boolean',
        'email_verifikasi' => 'datetime',
    ];

    /**
     * Relasi Many-to-Many dengan Peran
     */
    public function peran()
    {
        return $this->belongsToMany(Peran::class, 'peran_pengguna', 'pengguna_id', 'peran_id');
    }

    /**
     * Relasi Many-to-Many dengan OPD
     */
    public function opd()
    {
        return $this->belongsToMany(OPD::class, 'opd_pengguna', 'pengguna_id', 'opd_id');
    }
}
