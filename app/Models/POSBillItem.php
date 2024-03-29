<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSBillItem extends Model
{
    use HasFactory;
    protected $table = 'posbillitem';
    protected $guarded = ['id'];


    public function Store()
    {
        return $this->belongsTo(Store::class);
    }

    public function Posbill()
    {
        return $this->belongsTo(POSBill::class);
    }
}
