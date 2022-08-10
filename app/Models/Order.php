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


    public function Users()
    {
        return $this->belongsTo(User::class);
    }

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }


    public function Orderitem()
    {
        return $this->hasMany(Orderitem::class, 'order_id');
    }
}
