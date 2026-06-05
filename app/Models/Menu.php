<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'nama_menu',
        'harga',
        'deskripsi',
        'stok',
        'kategori',
        'gambar',
        'status',
    ];

    /**
     * Relasi ke Order: Satu jenis menu bisa dipesan di banyak baris detail order pesanan
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_menu', 'id');
    }
}