<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStatusAduan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status_aduan';
    public $timestamps = false;

    protected $fillable = [
        'aduan_id',
        'status_aduan_id',
        'catatan',
        'pengguna_id',
        'waktu_status_aduan',
        'unit_opd_id',
    ];

    /**
     * Relasi Many-to-One dengan Aduan
     */
    public function aduan()
    {
        return $this->belongsTo(Aduan::class, 'aduan_id');
    }

    /**
     * Relasi Many-to-One dengan StatusAduan
     */
    public function statusAduan()
    {
        return $this->belongsTo(StatusAduan::class, 'status_aduan_id');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function unitOpd()
    {
        return $this->belongsTo(UnitOpd::class, 'unit_opd_id');
    }
}
