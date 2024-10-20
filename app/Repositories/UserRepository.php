<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserRepository implements UserRepositoryInterface
{
    public function UsersRegister( $userData)
    {

          // create a new user
          $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
            'is_admin'=>$userData['is_admin'] ?? 0,
        ]);

        return ($user);

    }


}
