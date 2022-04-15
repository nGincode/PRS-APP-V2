<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Peralatan extends Model
{
    use HasFactory;
    protected $table = 'master_peralatan';
    protected $guarded = ['id'];
}
