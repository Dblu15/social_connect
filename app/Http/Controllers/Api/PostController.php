<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->paginate(10);

        return response()->json([
            'data' => $posts
        ]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        return response()->json([
            'message' => 'Post created successfully.',
            'data'    => $post
        ], 201);
    }

    public function show($id)
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

    public function update(PostRequest $request, $id)
    {
        $post = Post::query()->find($id);

        if (!$post){
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('posts');
            $data['image'] = $image;
        }

        $post->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully.',
            'data' => $post
        ], 201);
    }

    public function destroy($id)
    {
        $post = Post::query()->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found.',
            ]);
        }

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.'
        ], 204);
    }
}
