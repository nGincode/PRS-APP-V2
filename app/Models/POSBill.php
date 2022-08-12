<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSBill extends Model
{
    use HasFactory;
    protected $table = 'posbill';
    protected $guarded = ['id'];


    public function POSBillItem()
    {
        return $this->hasMany(POSBillItem::class, 'posbill_id');
    }

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
}
