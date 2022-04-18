<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olahan_Bahan extends Model
{
    use HasFactory;

    protected $table = 'olahan_bahan';
    protected $guarded = ['id'];
}
