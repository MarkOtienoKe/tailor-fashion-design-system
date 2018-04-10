<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 29/03/2018
 * Time: 23:45
 */

namespace App\Repositories;
use App\Role;

class RoleRepository
{
    public static function deactiveRole($id)
    {
        $role = Role::find($id);

        $role->status = 'IN-ACTIVE';

        return $role->save();
    }
}