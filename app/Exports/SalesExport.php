<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = Carbon::parse($start)->startOfDay();
        $this->end = Carbon::parse($end)->endOfDay();
    }

    public function collection()
    {
        // Lấy dữ liệu doanh thu
        $raw = Order::query()
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tính tổng doanh thu
        $totalRevenue = $raw->sum('revenue');

        // Chuẩn bị dữ liệu cho Excel
        $data = $raw->map(function ($row) use ($totalRevenue) {
            $percentage = $totalRevenue > 0 ? ($row->revenue / $totalRevenue * 100) : 0;
            return [
                'date' => $row->date,
                'revenue' => $row->revenue,
                'percentage' => $percentage,
            ];
        })->toArray();

        // Thêm dòng tổng cộng
        $data[] = [
            'date' => 'Tổng cộng',
            'revenue' => $totalRevenue,
            'percentage' => 100,
        ];

        return collect($data);
    }

    public function map($row): array
    {
        return [
            $row['date'] === 'Tổng cộng' ? 'Tổng cộng' : Carbon::parse($row['date'])->format('d/m/Y'),
            number_format($row['revenue'], 0) . ' ₫',
            number_format($row['percentage'], 1) . '%',
        ];
    }

    public function headings(): array
    {
        return [
            'Ngày',
            'Doanh thu (₫)',
            'Tỷ lệ (%)',
        ];
    }

    public function title(): string
    {
        return 'Báo cáo Doanh thu';
    }

    public function styles(Worksheet $sheet)
    {
        // Tiêu đề file
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'BÁO CÁO DOANH THU THEO NGÀY');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['argb' => 'FF000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Định dạng tiêu đề bảng
        $sheet->getStyle('A2:C2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0066CC'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Định dạng dữ liệu
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A3:C' . $highestRow)->applyFromArray([
            'font' => [
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Định dạng dòng tổng cộng
        if ($highestRow > 2) {
            $sheet->getStyle('A' . $highestRow . ':C' . $highestRow)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFDC3545'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFF8F9FC'],
                ],
            ]);
        }

        // Căn chỉnh cột
        $sheet->getStyle('A3:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B3:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('C3:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Tô màu xen kẽ cho các dòng (trừ dòng tổng cộng)
        for ($row = 3; $row < $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':C' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF8F9FC'],
                    ],
                ]);
            }
        }

        // Điều chỉnh độ cao hàng tiêu đề
        $sheet->getRowDimension(2)->setRowHeight(25);

        return [];
    }
}
