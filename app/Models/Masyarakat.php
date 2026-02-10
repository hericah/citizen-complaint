<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    use HasFactory;

    protected $table = 'masyarakat';
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'no_telp',
        'alamat',
        'pengguna_id',
    ];

    /**
     * Relasi Many-to-One dengan Pengguna
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
