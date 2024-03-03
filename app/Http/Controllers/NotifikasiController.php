<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationResourceCollection;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id;
        $posts = Post::where('id_user', $user)->get();

        $postIds = $posts->pluck('id')->toArray();

        $data = Notification::with(['posts', 'user'])
            ->whereIn('id_post', $postIds)
            ->get();


        return new NotificationResourceCollection($data);
    }

    public function update(NotificationRequest $request, $id)
    {
        $request->validated();
        $notif = Notification::with(['posts', 'user'])->findOrFail($id);
        $notif->update([
            'is_seen' => $request->is_seen
        ]);

        return new NotificationResource($notif);
    }
}
