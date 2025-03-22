<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $comments = Comment::query()->paginate(5);

        return response()->json([
            'status' => 'success',
            'data' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request): JsonResponse
    {
        $data = $request->validated();

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('comments', 'public');
        }

        $comment = Comment::create($data);

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment,
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $comment = Comment::query()->find($id);

        if(! $comment){
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found.',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, $id): JsonResponse
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found.',
            ]);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($comment->image) {
                Storage::delete($comment->image);
            }
            $data['image'] = $request->file('image')->store('comments', 'public');
        } else {
            $data['image'] = $comment->image;
        }

        $comment->update($data);

        return response()->json([
            'message' => 'Comment updated successfully',
            'data' => $comment,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if(! $comment){
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found.',
            ]);
        }
        if($comment->image){
            Storage::delete($comment->image);
        }
        $comment->delete();
        return response()->json([
            'satus' => 'success',
            'message' => 'Comment deleted successfully.',
        ],200);
    }
}
