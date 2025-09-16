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

class OrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    public function collection()
    {
        // Lấy dữ liệu trạng thái đơn hàng
        $raw = Order::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderBy('status')
            ->get();

        // Tính tổng số đơn hàng
        $totalCount = $raw->sum('count');

        // Chuẩn bị dữ liệu cho Excel
        $data = $raw->map(function ($row) use ($totalCount) {
            $percentage = $totalCount > 0 ? ($row->count / $totalCount * 100) : 0;
            return [
                'status' => ucfirst($row->status),
                'count' => $row->count,
                'percentage' => $percentage,
            ];
        })->toArray();

        // Thêm dòng tổng cộng
        $data[] = [
            'status' => 'Tổng cộng',
            'count' => $totalCount,
            'percentage' => 100,
        ];

        return collect($data);
    }

    public function map($row): array
    {
        return [
            $row['status'],
            $row['count'],
            number_format($row['percentage'], 1) . '%',
        ];
    }

    public function headings(): array
    {
        return [
            'Trạng thái',
            'Số lượng đơn',
            'Tỷ lệ (%)',
        ];
    }

    public function title(): string
    {
        return 'Báo cáo Đơn hàng';
    }

    public function styles(Worksheet $sheet)
    {
        // Tiêu đề file
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'BÁO CÁO ĐƠN HÀNG THEO TRẠNG THÁI');
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
                'startColor' => ['argb' => 'FF007BFF'],
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
        $sheet->getStyle('A3:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B3:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
