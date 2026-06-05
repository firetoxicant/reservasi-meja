<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function reservasis(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'id_pelanggan', 'id');
    }

    /**
     * Relasi ke Pembayaran: Seorang kasir bisa melayani banyak transaksi pelunasan pembayaran
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_kasir', 'id');
    }
}
