<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $notifications = Notification::all();
        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request): JsonResponse
    {
        $notification = Notification::create($request->validated());
        return response()->json([
            'status' => 'success',
            'data' => $notification
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $notification = Notification::find($id);
        if(! $notification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Notification not found'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'data' => $notification
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
//    public function update(NotificationRequest $request, $id): JsonResponse
//    {
//
//    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $notification = Notification::find($id);
        if(! $notification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Notification not found'
            ]);
        }
        $notification->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Notification deleted successfully.'
        ]);
    }
}
