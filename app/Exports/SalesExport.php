<?php

namespace App\Exports;

use App\Models\Sale;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Sales::with(['customers', 'payment_form', 'payment_method', 'state_types'])
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Cliente',
            'No. Factura',
            'Estado',
            'Forma de Pago',
            'Método de Pago',
            'Subtotal',
            'IVA',
            'Descuento',
            'Total'
        ];
    }

    /**
     * @param mixed $sale
     * @return array
     */
    public function map($sale): array
    {
        $invoiceNumber = $sale->series && $sale->number ? 
            "{$sale->series}-{$sale->number}" : 
            ($sale->invoice_no ? $sale->invoice_no : 'N/A');

        return [
            $sale->id,
            $sale->date_of_issue,
            $sale->customers ? $sale->customers->name : 'N/A',
            $invoiceNumber,
            $sale->state_types ? $sale->state_types->description : 'N/A',
            $sale->payment_form ? $sale->payment_form->payment_type : 'N/A',
            $sale->payment_method ? $sale->payment_method->name : 'N/A',
            $sale->total_subtotal,
            $sale->total_tax,
            $sale->total_discount,
            $sale->total_sale
        ];
    }
}