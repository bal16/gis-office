<?php

namespace App\Filament\Resources\AdministrationResource\Pages;

use App\Filament\Resources\AdministrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdministrations extends ListRecords
{
    protected static string $resource = AdministrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
