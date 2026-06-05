<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'kode_reservasi',
        'id_pelanggan',
        'id_meja',
        'jam_mulai',
        'jam_selesai',
        'tanggal_reservasi',
        'bukti',
        'status_reservasi',
    ];

    /**
     * Relasi balik ke User (Pelanggan yang memesan)
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pelanggan', 'id');
    }

    /**
     * Relasi balik ke Meja yang dipilih
     */
    public function meja(): BelongsTo
    {
        return $this->belongsTo(Meja::class, 'id_meja', 'id');
    }

    /**
     * Relasi ke detail makanan yang diorder (`tbl_order` native)
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_reservasi', 'id');
    }

    /**
     * Relasi ke data pembayaran uang muka / pelunasan
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_reservasi', 'id');
    }
}