<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posbillitem extends Model
{
    use HasFactory;
    protected $table = 'posbillitem';
    protected $guarded = ['id'];
}
