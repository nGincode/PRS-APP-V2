<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupsUsers extends Model
{
    use HasFactory;

    protected $table = 'groups_users';
    protected $guarded = ['id'];

    public function Groups()
    {
        return $this->belongsTo(Groups::class);
    }

    public function Users()
    {
        return $this->belongsTo(User::class);
    }
}
