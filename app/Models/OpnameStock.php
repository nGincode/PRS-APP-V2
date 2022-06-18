<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpnameStock extends Model
{
    use HasFactory;
    protected $table = 'opnamestock';
    protected $guarded = ['id'];
}
