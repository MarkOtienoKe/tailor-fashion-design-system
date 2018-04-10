<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 26/01/2018
 * Time: 17:31
 */
namespace App\Repositories;
use App\User;
use function bcrypt;


class UserRepository
{
    public static function deactiveUser($id)
    {
        $user = User::find($id);

        $user->status = 'IN-ACTIVE';

        return $user->save();
    }
    public static function createUser($request)
    {
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;

        return $user->save();
    }
    public static function editUser($request)
    {
        $user = User::find($request->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        return $user->save();
    }
}