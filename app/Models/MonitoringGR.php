<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringGR extends Model
{
    protected $table = 'monitoring_gr'; // atau nama tabel yang kamu pakai
    protected $fillable = ['no_po', 'judul', 'no_gr', 'nilai_gr'];
}
