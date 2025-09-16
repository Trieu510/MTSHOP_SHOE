<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockLogExport implements FromCollection, WithHeadings
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs->map(function ($log) {
            return [
                'Sản phẩm' => $log->variant->product->name ?? '-',
                'Size' => $log->variant->size ?? '-',
                'Số lượng' => $log->quantity,
                'Ghi chú' => $log->note,
                'Người nhập' => $log->admin->name ?? '-',
                'Thời gian' => $log->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Sản phẩm', 'Size', 'Số lượng', 'Ghi chú', 'Người nhập', 'Thời gian'];
    }
}

