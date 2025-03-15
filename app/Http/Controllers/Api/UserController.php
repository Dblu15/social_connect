<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->paginate(10);

        return response()->json([
            'data' => $users
        ]);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }
        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully.',
            'data'    => $user
        ], 201);
    }

    public function show($id)
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

    public function update(UserRequest $request, $id)
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
            $avatar = $request->file('avatar')->store('avatar');
            $data['avatar'] = $avatar;
        }
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully.',
            'data'    => $user
        ], 201);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.'
        ], 200);
    }
}
