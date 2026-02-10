<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    use HasFactory;

    protected $table = 'hak_akses';
    public $timestamps = false;

    protected $fillable = [
        'menu_id',
        'peran_id',
    ];

    /**
     * Relasi Many-to-One dengan Peran
     */
    public function peran()
    {
        return $this->belongsTo(Peran::class, 'peran_id');
    }

    /**
     * Relasi Many-to-One dengan Menu
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
