<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'jabatan';
    protected $fillable = [
        'nama_jabatan',
        'jenis_jabatan_id'
    ];

    public function jenis_jabatan()
    {
        return $this->belongsTo(JenisJabatan::class);
    }
}
