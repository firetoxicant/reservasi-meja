<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'mejas';

    protected $fillable = [
        'nama_meja',
        'kapasitas_meja',
        'status',
        'foto', // Tambahkan field foto di sini
    ];

    public function reservasis(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'id_meja', 'id');
    }
}