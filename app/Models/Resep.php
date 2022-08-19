<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    public $asYouType = true;

    protected $table = 'resep';
    protected $guarded = ['id'];

    public function Bahan()
    {
        return $this->belongsToMany(Bahan::class)->withPivot('pemakaian')->withTimestamps();
    }
}
