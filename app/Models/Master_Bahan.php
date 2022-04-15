<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Bahan extends Model
{
    use HasFactory;

    protected $table = 'master_bahan';
    protected $guarded = ['id'];
}
