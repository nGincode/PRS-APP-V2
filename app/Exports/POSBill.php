<?php

namespace App\Exports;

use App\Models\POSBill;
use Maatwebsite\Excel\Concerns\FromCollection;

class POSBill implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return POSBill::all();
    }
}
