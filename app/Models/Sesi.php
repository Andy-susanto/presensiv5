<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'sesi';
    protected $fillable = [
        'nama',
        'aktif'
    ];
}
