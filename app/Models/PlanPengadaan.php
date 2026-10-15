<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPengadaan extends Model
{
    use HasFactory;

    protected $table = 'plan_pengadaan';

    protected $fillable = [
        'proyek_id',
        'id_plan',
        'status',
    ];

    public function proyek()
    {
        return $this->belongsTo(ProyekPengadaan::class, 'proyek_id');
    }
}
