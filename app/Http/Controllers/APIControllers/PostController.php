<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $posts = Post::query()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    public function store(PostRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        return response()->json([
            'message' => 'Post created successfully.',
            'data'    => $post
        ], 200);
    }

    public function show($id): JsonResponse
    {
        $post = Post::query()->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ]);
        }
        return response()->json([
            'data' => $post
        ]);
    }

    public function update(PostRequest $request, $id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post){
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts');
        }else{
            $data['image'] = $post->image;
        }

        $post->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully.',
            'data' => $post
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $post = Post::query()->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ]);
        }

        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully.'
        ], 200);
    }
}
