<?php

namespace App\Filament\Resources\CustomerInvoiceItemResource\Pages;

use App\Filament\Resources\CustomerInvoiceItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerInvoiceItem extends CreateRecord
{
    protected static string $resource = CustomerInvoiceItemResource::class;
}
