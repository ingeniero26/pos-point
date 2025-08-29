<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class InventoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $inventory;

    public function __construct($inventory)
    {
        $this->inventory = $inventory;
    }

    public function collection()
    {
        return $this->inventory;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item',
            'Warehouse',
            'Stock',
            'Company',
            'Created At',
            'Updated At',
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->id,
            $inventory->item ? $inventory->item->product_name : 'N/A',
            $inventory->warehouse ? $inventory->warehouse->warehouse_name : 'N/A',
            $inventory->stock,
            $inventory->company ? $inventory->company->name : 'N/A',
            $inventory->created_at ? $inventory->created_at->format('Y-m-d H:i:s') : 'N/A',
            $inventory->updated_at ? $inventory->updated_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Inventory';
    }
}