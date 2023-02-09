<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use App\Models\Pegawai;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPegawais extends ListRecords
{
    protected static string $resource = PegawaiResource::class;

    protected static ?string $title = 'Pegawai';
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
