<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Olahan extends Model
{
    use HasFactory;

    protected $table = 'olahan';
    protected $guarded = ['id'];

    public function Bahan()
    {
        return $this->belongsToMany(Bahan::class, 'olahan_bahan');
    }
}
