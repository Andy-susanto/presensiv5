<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisJabatan extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'jenis_jabatan';
    protected $fillable = [
        'kode',
        'nama'
    ];
}
