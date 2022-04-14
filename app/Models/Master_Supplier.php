<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Supplier extends Model
{
    use HasFactory;

    protected $table = 'master_supplier';
    protected $guarded = ['id'];
}
