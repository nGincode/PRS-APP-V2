<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket_Tukar extends Model
{
    use HasFactory;

    protected $table = 'ticket_tukar';
    protected $guarded = ['id'];


    public function Ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
