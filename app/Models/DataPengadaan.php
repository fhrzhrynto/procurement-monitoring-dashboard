<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPengadaan extends Model
{
    use HasFactory;

    protected $table = 'data_pengadaans'; // Pastikan nama tabel sesuai dengan migrasi

    protected $fillable = [
        'nama_pengadaan', 'tor', 'rab', 'sph', 'bcr', 'nodin', 'file_path'
    ];
}
