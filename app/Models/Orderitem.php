<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;

    protected $table = 'orderitem';
    protected $guarded = ['id'];


    public function Store()
    {
        return $this->belongsTo(Store::class);
    }

    public function Bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
