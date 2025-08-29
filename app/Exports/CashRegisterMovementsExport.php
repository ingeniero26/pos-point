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

class CashRegisterMovementsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected $movements;
    protected $totals;

    public function __construct($movements, $totals)
    {
        $this->movements = $movements;
        $this->totals = $totals;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->movements;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Caja',
            'Estado Caja',
            'Tipo',
            'Monto',
            'Método de Pago',
            'Categoría',
            'Descripción',
            'Usuario',
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($movement): array
    {
        // Format date
        $date = Carbon::parse($movement->movement_date)->format('d/m/Y H:i');
        
        // Format cash register status
        $registerStatus = 'N/A';
        if ($movement->cashRegister) {
            if ($movement->cashRegister->status === 'open') {
                $registerStatus = 'Abierta';
            } elseif ($movement->cashRegister->status === 'closed') {
                $registerStatus = 'Cerrada';
            } else {
                $registerStatus = 'Inactiva';
            }
        }
        
        // Format amount with sign based on movement type
        $amount = $movement->amount;
        if ($movement->movement_type === 'Ingreso') {
            $amount = '+' . number_format($amount, 2, '.', ',');
        } elseif ($movement->movement_type === 'Egreso') {
            $amount = '-' . number_format($amount, 2, '.', ',');
        } else {
            $amount = number_format($amount, 2, '.', ',');
        }
        
        return [
            $movement->id,
            $date,
            $movement->cashRegister ? $movement->cashRegister->name : 'N/A',
            $registerStatus,
            $movement->movement_type,
            $amount,
            $movement->paymentMethod ? $movement->paymentMethod->name : 'N/A',
            $movement->category ? $movement->category->name : 'N/A',
            $movement->description ?: 'N/A',
            $movement->createdBy ? $movement->createdBy->name : 'N/A',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Style the header row
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A7BDF'],
            ],
        ]);
        
        // Add summary at the bottom
        $lastRow = $sheet->getHighestRow() + 2;
        
        $sheet->setCellValue('A' . $lastRow, 'RESUMEN');
        $sheet->mergeCells('A' . $lastRow . ':J' . $lastRow);
        $sheet->getStyle('A' . $lastRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        
        $lastRow += 1;
        $sheet->setCellValue('A' . $lastRow, 'Ingresos:');
        $sheet->setCellValue('B' . $lastRow, number_format($this->totals['income'], 2, '.', ','));
        $sheet->getStyle('B' . $lastRow)->getFont()->getColor()->setRGB('008800');
        
        $lastRow += 1;
        $sheet->setCellValue('A' . $lastRow, 'Egresos:');
        $sheet->setCellValue('B' . $lastRow, number_format($this->totals['expense'], 2, '.', ','));
        $sheet->getStyle('B' . $lastRow)->getFont()->getColor()->setRGB('FF0000');
        
        $lastRow += 1;
        $sheet->setCellValue('A' . $lastRow, 'Ajustes:');
        $sheet->setCellValue('B' . $lastRow, number_format($this->totals['adjustment'], 2, '.', ','));
        $sheet->getStyle('B' . $lastRow)->getFont()->getColor()->setRGB('FF8800');
        
        $lastRow += 1;
        $sheet->setCellValue('A' . $lastRow, 'Saldo:');
        $sheet->setCellValue('B' . $lastRow, number_format($this->totals['balance'], 2, '.', ','));
        $sheet->getStyle('B' . $lastRow)->getFont()->getColor()->setRGB('0000FF');
        $sheet->getStyle('A' . ($lastRow-3) . ':B' . $lastRow)->getFont()->setBold(true);
        
        // Add report generation info
        $lastRow += 2;
        $sheet->setCellValue('A' . $lastRow, 'Reporte generado el ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A' . $lastRow . ':J' . $lastRow);
        $sheet->getStyle('A' . $lastRow)->applyFromArray([
            'font' => ['italic' => true, 'size' => 10],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);
        
        return [
            // Set all cells to be aligned center vertically
            1 => ['alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Movimientos de Caja';
    }
}