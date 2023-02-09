<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'jadwal';
    protected $fillable = [
        'tanggal',
        'sesi_id',
        'pegawai_id',
        'unit_kerja_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }
}
