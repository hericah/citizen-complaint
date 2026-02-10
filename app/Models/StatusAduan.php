<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAduan extends Model
{
    use HasFactory;

    protected $table = 'status_aduan';
    public $timestamps = false;

    protected $fillable = [
        'nama_status',
        'urutan',
    ];

    /**
     * Relasi One-to-Many dengan RiwayatStatusAduan
     */
    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusAduan::class, 'status_aduan_id');
    }
}
