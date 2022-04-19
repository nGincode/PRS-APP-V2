<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan_Olahan extends Model
{
    use HasFactory;

    protected $table = 'bahan_olahan';
    protected $guarded = ['id'];

    public function Bahan()
    {
        return $this->belongsTo(Bahan::class);
    }


    public function Olahan()
    {
        return $this->belongsTo(Olahan::class);
    }
}
