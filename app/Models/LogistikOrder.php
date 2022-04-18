<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogistikOrder extends Model
{
    use HasFactory;

    protected $table = 'logistikorder';
    protected $guarded = ['id'];
}
