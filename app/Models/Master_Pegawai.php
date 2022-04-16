<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master_Pegawai extends Model
{
    use HasFactory;
    protected $table = 'master_pegawai';
    protected $guarded = ['id'];

    public function Store()
    {
        return $this->belongsTo(Store::class);
    }
}
