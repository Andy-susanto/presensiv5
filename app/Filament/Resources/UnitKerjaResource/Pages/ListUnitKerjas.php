<?php

namespace App\Filament\Resources\UnitKerjaResource\Pages;

use App\Filament\Resources\UnitKerjaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnitKerjas extends ListRecords
{
    protected static string $resource = UnitKerjaResource::class;
    protected static ?string $title = 'Unit Kerja';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
