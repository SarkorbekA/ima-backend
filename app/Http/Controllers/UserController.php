<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Exceptions\BusinessException;
use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\BaseUserResource;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Faker\Provider\Base;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param UserService $service
     * @return AnonymousResourceCollection
     */
    public function index(
        UserService $service,
    ): AnonymousResourceCollection
    {
        $users = $service->index();

        return BaseUserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param UserCreateRequest $request
     * @param UserService $service
     * @return JsonResponse
     * @throws DuplicateEntryException
     */
    public function store(
        UserCreateRequest $request,
        UserService       $service,
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->create(UserDTO::fromArray($validated));
    }


    /**
     * Display the specified resource.
     * @throws ModelNotFoundException
     */
    public function show(
        UserService $service,
        int         $id
    ): UserResource
    {
        $user = $service->show($id);

        return new UserResource($user);
    }

    /**
     * @return UserResource
     */
    public function profile(): UserResource
    {
        $user = Auth::user();

        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     * @param UserUpdateRequest $request
     * @param UserService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function update(
        UserUpdateRequest $request,
        UserService       $service,
        int               $id
    ): JsonResponse
    {
        $validated = $request->validated();

        return $service->update(UserDTO::fromArray($validated), $id);
    }

    /**
     * Update the specified resource in storage.
     * @param UserService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function changeStatus(
        UserService $service,
        int         $id
    ): JsonResponse
    {
        return $service->changeStatus($id);
    }

    /**
     * Remove the specified resource from storage.
     * @param UserService $service
     * @param int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function destroy(
        UserService $service,
        int         $id
    ): JsonResponse
    {
        return $service->delete($id);
    }


}
