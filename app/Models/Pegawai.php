<?php

namespace App\Models;

use App\Models\Concerns\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
// use Laravel\Scout\Searchable;

class Pegawai extends Model
{
    use HasFactory, UuidTrait;
    // protected $connection = 'oracle';
    // public $sequence = null;
    // protected $binaries = [
    //     'nm_pgw',
    //     'gelar_depan',
    //     'nip'
    // ];
    // protected $primaryKey = 'kd_aktif';
    protected $table = 'pegawai';
    // protected $fillable = [
    //     'nm_aktif',
    // ];
    protected $fillable = [
        'unit_kerja_id',
        'jabatan_id',
        'nama_pegawai',
        'nip',
        'gelar_depan',
        'gelar_belakang',
    ];

    public function namaPegawai(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($this->gelar_depan ?? null) . ' ' . $value . ' ' . ($this->gelar_belakang ? ', ' . $this->gelar_belakang : ' ')
        );
    }

    public function unit_kerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function makeUser()
    {
        $user =  User::updateOrCreate(
            [
                'pegawai_id' =>  $this->id
            ],
            [
                'username' => $this->nip,
                'name' => $this->nama_pegawai,
                'password' => Hash::make($this->username)
            ]
        );

        return $user;
    }
}
