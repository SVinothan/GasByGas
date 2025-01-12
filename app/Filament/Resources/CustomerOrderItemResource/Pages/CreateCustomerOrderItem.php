<?php

namespace App\Filament\Resources\CustomerOrderItemResource\Pages;

use App\Filament\Resources\CustomerOrderItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerOrderItem extends CreateRecord
{
    protected static string $resource = CustomerOrderItemResource::class;
}
