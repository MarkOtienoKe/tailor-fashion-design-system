<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 30/03/2018
 * Time: 09:56
 */

namespace App\Repositories;


use App\Permission;

class PermissionRepository
{
    public static function deactivatePermission($id)
    {
        $role = Permission::find($id);

        $role->status = 'IN-ACTIVE';

        return $role->save();
    }
}