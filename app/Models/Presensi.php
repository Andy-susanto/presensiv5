<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'presensi';
    protected $fillable = [
        'pegawai_id',
        'waktu',
        'foto_presensi',
        'keterangan',
        'ip_address',
    ];


    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
