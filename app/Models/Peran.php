<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    use HasFactory;

    protected $table = 'peran';
    public $timestamps = false;

    protected $fillable = [
        'nama_peran',
    ];

    /**
     * Relasi Many-to-Many dengan Pengguna
     */
    public function pengguna()
    {
        return $this->belongsToMany(Pengguna::class, 'peran_pengguna', 'peran_id', 'pengguna_id');
    }

    /**
     * Relasi One-to-Many dengan HakAkses
     */
    public function hakAkses()
    {
        return $this->hasMany(HakAkses::class, 'peran_id');
    }
}
