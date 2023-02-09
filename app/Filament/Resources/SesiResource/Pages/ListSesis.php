<?php

namespace App\Filament\Resources\SesiResource\Pages;

use App\Filament\Resources\SesiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesis extends ListRecords
{
    protected static string $resource = SesiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
