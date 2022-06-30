<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Bahan extends Model
{
    use HasFactory, Searchable;

    protected $table = 'bahan';
    protected $guarded = ['id'];


    public function Olahan()
    {
        return $this->belongsToMany(Olahan::class, 'olahan_bahan');
    }


    public function searchableAs()
    {
        return 'Bahan';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama
        ];
    }
}
