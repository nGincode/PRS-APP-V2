<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    use HasFactory;

    protected $table = 'closing';
    protected $guarded = ['id'];

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
}
