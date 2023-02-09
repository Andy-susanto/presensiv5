<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPresensi extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'lokasi_presensi';
    protected $fillable = [
        'ip_address',
        'lokasi',
        'aktif'
    ];
}
