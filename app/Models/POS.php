<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POS extends Model
{
    use HasFactory;
    protected $table = 'pos';
    protected $guarded = ['id'];


    public function Bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
    public function Inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
