<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ShowUserResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return UserResource::collection(User::paginate(10));
    }

    public function store(StoreUserRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'active' => $request->active,
        ]);

        return response()->json($user, 201);
    }

    public function show(string $id): ShowUserResource
    {
        $user = User::with('groups')->findOrFail($id);

        return new ShowUserResource($user);
    }

    public function update(UpdateUserRequest $request, string $id): UserResource
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request['name'],
            'active' => $request['active'],
        ];

        if ($request->has('email') && $request['email'] !== $user->email) {
            $data['email'] = $request['email'];
        }

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(string $id): \Illuminate\Http\Response
    {
        $user = User::findOrfail($id);
        $user->delete();
        return response()->noContent();
    }
}
