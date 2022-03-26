<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogistikProduk extends Model
{
    use HasFactory;

    protected $table = 'logistik_produk';
    protected $guarded = ['id'];
}
