<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'id_reservasi',
        'total_awal',
        'dp',
        'bayar',
        'kembali',
        'id_pelanggan',
        'id_kasir',
    ];

    /**
     * Relasi balik ke data Reservasi terkait
     */
    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi', 'id');
    }

    /**
     * Relasi ke User dengan role Pelanggan
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }

    /**
     * Relasi ke User dengan role Kasir yang memverifikasi pelunasan di kasir
     */
    public function kasir(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kasir', 'id');
    }
}