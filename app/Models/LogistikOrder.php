<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogistikOrder extends Model
{
    use HasFactory;

    protected $table = 'logistik_order';
    protected $guarded = ['id'];
}
