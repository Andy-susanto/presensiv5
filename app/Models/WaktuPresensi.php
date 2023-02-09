<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaktuPresensi extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'waktu_presensi';
    protected $fillable = [
        'hari',
        'waktu_mulai',
        'waktu_selesai',
        'status',
        'sesi_id'
    ];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }
}
