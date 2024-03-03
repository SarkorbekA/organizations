<?php

namespace App\Http\Controllers\Auth;

use App\DTO\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\UserSendEmail;
use App\Models\User;
use App\Services\create\CreateUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class LoginRegisterController extends Controller
{
    /**
     * Register a new user.
     * @param App\Http\Requests\RegisterRequest $request
     * @param App\Services\CreateUserService $service
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request, CreateUserService $service): JsonResponse
    {
        $validated = $request->validated();

        $user = $service->execute(UserDTO::fromArray($validated));

        $data['token'] = $user->createToken($request->validated('email'))->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => __('messages.success'),
            'message' => __('messages.status_message'),
            'data' => $data,
        ];

        $random = rand(100000, 999999);

        cache()->remember('confirmation_code', 120, function () use ($random) {
            return $random;
        });

        UserSendEmail::dispatch($user, $random);


//        dd($random);
        return response()->json($response, 201);
    }

    /**
     * Authenticate the user.
     *
     * @param App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        // Check email exist
        $user = User::where('email', $request->email)->first();

        // Check password
        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $data['token'] = $user->createToken($request->validated('email'))->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'User is logged in successfully.',
            'data' => $data,
        ];

        return response()->json($response, 200);
    }

    /**
     * Log out the user from application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User is logged out successfully'
        ], 200);
    }
}
