<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

trait UserCheck
{
    public function checkUser($user_id)
    {
        $user = \App\Models\User::find($user_id);
        if ($user) {
            return $user;
        } else {
            return false;
        }
    }

    public function checkUserByEmailOrPhone($identifier)
    {
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($fieldType, $identifier)->first();
        if ($user) {
            return $user;
        }

        return false;
    }

    public function checkUserPassword(User $user, $password)
    {
        if (Hash::check($password, $user->password)) {
            return true;
        } else {
            return false;
        }
    }
}
