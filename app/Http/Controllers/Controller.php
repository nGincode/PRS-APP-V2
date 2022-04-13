<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\GroupsUsers;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function permission()
    {
        $Id = request()->session()->get('id');
        $DataGroup = GroupsUsers::join('groups', 'groups.id', '=', 'groups_users.groups_id')
            ->where('groups_users.users_id', $Id)
            ->first();
        return unserialize($DataGroup['permission']);
    }
}
