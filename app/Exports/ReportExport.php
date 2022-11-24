<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('order')
            ->select(['service.title as "Service Title"', 'b.name as "Buyer Name"', 'f.name as "Freelancer Name"', 'service.price as "Price"', 'order.expired as "Deadline"', 'order_status.name as "Status'])
            ->join('service', 'order.service_id', '=', 'service.id')
            ->join('users as b', 'order.buyer_id', '=', 'b.id')
            ->join('users as f', 'order.freelancer_id', '=', 'f.id')
            ->join('order_status', 'order.order_status_id', '=', 'order_status.id')
            ->get();
    }

    public function headings(): array
    {
        return ["Service Name", "Buyer Name", "Freelancer Name", "Price", "Deadline", "Status"];
    }

    public function columnFormats(): array
    {
        return [
            // 'D' => NumberFormat::Format_,
        ];
    }
}
