<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $users = User::query()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $validated['avatar'] = $path;
        }
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully.',
            'data'    => $user
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ]);
        }

        return response()->json([
            'data' => $user
        ]);
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        $user = User::query()->find($id);
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars');
        }else{
            $data['avatar'] = $user->avatar;
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'data'    => $user
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully.'
        ], 200);
    }
}
