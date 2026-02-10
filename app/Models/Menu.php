<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    public $timestamps = false;

    protected $fillable = [
        'menu_id_induk',
        'nama_menu',
        'ikon',
        'link',
        'status_aktif',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
    ];

    /**
     * Relasi Self-referencing untuk sub-menu
     */
    public function submenu()
    {
        return $this->hasMany(Menu::class, 'menu_id_induk');
    }

    public function menuInduk()
    {
        return $this->belongsTo(Menu::class, 'menu_id_induk');
    }

    /**
     * Relasi One-to-Many dengan HakAkses
     */
    public function hakAkses()
    {
        return $this->hasMany(HakAkses::class, 'menu_id');
    }
}
