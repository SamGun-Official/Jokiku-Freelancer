<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Order([
            'Service Name'     => $row->service()->first()->title,
            'Buyer Name'     => $row->user_buyer()->first()->name,
            'Freelancer Name'     => $row->user_freelancer()->first()->name,
            'Freelancer Name'     => $row->user_freelancer()->first()->name,
            'Price'     => 'Rp' .  number_format($row->service()->first()->price),
            'Deadline'     => $row["expired"],
            'Status'     => $row->order_status()->first()->name,
        ]);
    }
}
