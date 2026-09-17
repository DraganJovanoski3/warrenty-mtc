<?php

namespace App\Exports;

use App\Models\Installation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InstallationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function __construct(private array $filters = [])
    {
    }

    public function collection(): Collection
    {
        return Installation::query()
            ->with('product')
            ->filtered($this->filters)
            ->orderBy('installation_date')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Company Name',
            'Tax ID',
            'Customer Address',
            'Installer Company',
            'Truck Number',
            'VIN',
            'Mileage',
            'Installation Date',
            'Part Number',
            'Part Description',
            'Invoice Number',
            'Invoice Date',
            'Created At',
        ];
    }

    public function map($installation): array
    {
        return [
            $installation->id,
            $installation->company_name,
            $installation->tax_id,
            $installation->customer_address,
            $installation->installer_company_name,
            $installation->truck_number,
            $installation->vin,
            $installation->mileage_at_installation,
            optional($installation->installation_date)->format('Y-m-d'),
            $installation->part_number,
            $installation->part_description,
            $installation->invoice_number,
            optional($installation->invoice_date)->format('Y-m-d'),
            optional($installation->created_at)->format('Y-m-d H:i'),
        ];
    }
}
