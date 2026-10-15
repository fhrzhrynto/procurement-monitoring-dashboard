<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekPengadaan extends Model
{
    use HasFactory;

    protected $table = 'proyek_pengadaan';

    protected $fillable = [
        'nama_proyek',
        'deskripsi',
        'start_date',
        'target_date',
        'progress',
    ];

    public function planPengadaan()
    {
        return $this->hasMany(PlanPengadaan::class, 'proyek_id');
    }
}

