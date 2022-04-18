<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';
    protected $guarded = ['id'];


    public function Olahan()
    {
        return $this->belongsToMany(Olahan::class, 'olahan_bahan');
    }
}
