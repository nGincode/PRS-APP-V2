<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pos_bill extends Model
{
    use HasFactory;
    protected $table = 'posbill';
    protected $guarded = ['id'];
}
