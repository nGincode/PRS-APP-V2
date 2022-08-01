<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $guarded = ['id'];


    public function Order_Item()
    {
        return $this->belongsToMany(Order_Item::class, 'orderitem');
    }
}
