<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LikeRequest;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $likes = Like::query()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $likes
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function store(LikeRequest $request): JsonResponse
    {
        $post = Like::create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show($id): JsonResponse
    {
        $like = Like::find($id);
        if (!$like) {
            return response()->json([
                'status' => 'error',
                'message' => 'Like not found'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => $like
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    //    public function update(Request $request, Like $like)
    //    {
    //
    //    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $like = Like::find($id);
        if (!$like) {
            return response()->json([
                'status' => 'error',
                'message' => 'Like not found'
            ]);
        }

        $like->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Like deleted successfully'
        ]);
    }
}
