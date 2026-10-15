<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    use HasFactory;

    protected $table = 'pengadaan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'bigint';

    // Update fillable untuk mencakup kolom baru pada tabel
    protected $fillable = [
        'id',
        'no_kontrak',
        'no_po',
        'nama',
        'status',
        'total_kontrak',
        'start_date',
        'end_date',
        'penagihan',
    ];

    // Menambahkan kode untuk auto-generate ID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengadaan) {
            do {
                $randomId = mt_rand(10000, 99999);
            } while (self::where('id', $randomId)->exists());

            $pengadaan->id = $randomId;
        });
    }
    protected $casts = [
        'penagihan' => 'integer',
    ];
}
