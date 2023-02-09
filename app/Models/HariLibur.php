<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'hari_libur';
    protected $fillable = [
        'hari_libur',
        'tanggal'
    ];
}
