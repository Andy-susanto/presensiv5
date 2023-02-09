<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory, UuidTrait;
    protected $table = 'unit_kerja';
    public $fillable = [
        'nama_unit_kerja',
        'status'
    ];
}
