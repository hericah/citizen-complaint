<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOpd extends Model
{
    use HasFactory;

    protected $table = 'unit_opd';
    public $timestamps = true;
    const CREATED_AT = 'tanggal_dibuat';
    const UPDATED_AT = 'tanggal_diubah';

    protected $fillable = [
        'opd_id',
        'nama_unit',
        'kode_unit',
        'penanggung_jawab',
        'nama_pengguna',
    ];

    public function opd()
    {
        return $this->belongsTo(OPD::class, 'opd_id');
    }

    public function riwayat()
    {
        return $this->hasMany(\App\Models\RiwayatStatusAduan::class, 'unit_opd_id');
    }
}
