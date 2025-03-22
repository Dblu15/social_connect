<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShareRequest;
use App\Models\Post;
use App\Models\Share;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $shares = Share::query()->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $shares
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShareRequest $request): JsonResponse
    {
        $share = Share::create($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $share
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $share = Share::query()->find($id);

        if(!$share){
            return response()->json([
                'status' => 'error',
                'message' => 'Share does not exist'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $share
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(Request $request, Share $share): JsonResponse
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $share = Share::query()->find($id);
        if(!$share){
            return response()->json([
                'status' => 'error',
                'message' => 'Share does not exist'
            ]);
        }
        $share->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Share has been deleted'
        ]);
    }
}
