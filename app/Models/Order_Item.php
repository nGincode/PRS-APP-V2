<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Order_Item extends Model
{
    use HasFactory;

    protected $table = 'orderitem';
    protected $guarded = ['id'];


    public function Order()
    {
        return $this->belongsToMany(Order::class, 'Order');
    }
}
