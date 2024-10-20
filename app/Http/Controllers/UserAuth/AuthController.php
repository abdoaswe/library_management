<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserAuth\RegisterRequest;
use App\Http\Requests\UserAuth\LoginRequest;
use App\Traits\GeneralTraits;
use App\Interfaces\UserRepositoryInterface;

class AuthController extends Controller
{
    use GeneralTraits;


    private $userRepository;
    // Inject the UserRepositoryInterface into the controller
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function Register(RegisterRequest $request)
    {

        // Prepare the data from the request
        $userData = $request->only(['name', 'email', 'password', 'is_admin']);

        // Use the repository to create a new user
        $isUserCreated = $this->userRepository->UsersRegister($userData);


        if ($isUserCreated) {
            // If the user was created, send a success response.

            return $this->responseSuccess($isUserCreated, 'User created successfully', 201);
        } else {

            // If the user was not created, send a failure response.
            return $this->responseError('Failed to create user');
        }

    }

    public function login(LoginRequest $request)
    {


        // Attempt to authenticate the user.
        $credentials = $request->only('email', 'password');

        // If the authentication attempt fails, return an unauthorized response.
        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            // If the user was not authenticated, send a failure response.
            return $this->responseError('Unauthorized  Email or Password is Not Correct ', 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
