<?php

namespace App\Http\Controllers\Auth;

use App\DTO\UserDTO;
use App\Exceptions\AuthException;
use App\Exceptions\BusinessException;
use App\Exceptions\DuplicateEntryException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Services\LoginRegisterService;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginRegisterController extends Controller

{
    /**
     * @param UserRegisterRequest $request
     * @param LoginRegisterService $service
     * @throws AuthException|DuplicateEntryException
     */

    public function register(UserRegisterRequest $request, LoginRegisterService $service)
    {
        $validated = $request->validated();

        $user = $service->create(UserDTO::fromArray($validated));

        $expiresAt = now()->addDay();

        $tokenName = $request->validated('email') . '_' . $user->id;
        $data['token'] = $user->createToken($tokenName, ['*'], $expiresAt)->plainTextToken;

        $data['user'] = $user;

        throw new AuthException(
            'Регистрация прошла успешно!',
            Response::HTTP_CREATED,
            'Успешно!',
            $data
        );
    }

    /**
     * Authenticate the user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AuthException|BusinessException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();


        if (!$user || !Hash::check($request->validated('password'), $user->password)) {
            throw new BusinessException('Неверные учетные данные.', Response::HTTP_UNAUTHORIZED);
        }

        $data['token'] = $user->createToken($request->validated('email'))->plainTextToken;
        $data['user'] = $user;

        throw new AuthException(
            'Пользователь успешно вошел в систему!',
            Response::HTTP_OK,
            'Успешно!',
            $data
        );
    }

    /**
     * Log out the user from application.
     *
     * @return JsonResponse
     * @throws BusinessException|AuthException
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        throw new AuthException(
            'Пользователь успешно вышел из системы!',
            Response::HTTP_OK,
            'Успешно!',
        );
    }
}
