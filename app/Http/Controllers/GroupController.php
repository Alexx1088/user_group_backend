<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ShowGroupResource;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return GroupResource::collection(Group::paginate(10));
    }

    public function store(StoreGroupRequest $request): \Illuminate\Http\JsonResponse
    {
        $group = Group::create([
            'name' => $request->name,
            'expire_hours' => $request->expire_hours,
        ]);

        return response()->json($group, 201);
    }


    public function show(string $id): ShowGroupResource
    {
        $group = Group::with('users')->findOrFail($id);

        return new ShowGroupResource($group);
    }


    public function update(UpdateGroupRequest $request, string $id): GroupResource
    {
        $group = Group::findOrFail($id);

        $group->update([
            'name' => $request->name,
            'expire_hours' => $request->expire_hours,
        ]);

        return new GroupResource($group);
    }


    public function destroy(string $id): \Illuminate\Http\Response
    {
        $group = Group::findOrFail($id);

        $group->delete();

        return response()->noContent();
    }
}
