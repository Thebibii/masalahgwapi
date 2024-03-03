<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $req, $id)
    {
        $req->validated();

        $comment = Comment::create([
            'content' => $req->content,
            'id_user' => Auth::user()->id,
            'id_post' => $id
        ]);

        $comment->load('post');
        $comment->load('user');

        Notification::create([
            'id_user' => Auth::user()->id,
            'id_post' => $id,
            'id_comment' => $comment->id
        ]);

        return (new CommentsResource($comment))->pesan("Comment success dikirim");
    }

    public function update(CommentRequest $req, $id)
    {
        $user = Auth::user()->id;
        $comment = Comment::where('id', $id)->where('id_user', $user)->first();
        if (!$comment) {
            throw new HttpResponseException(response([
                "errors" => [
                    'code' => 404,
                    'message' => 'Comment Tidak Ditemukan'
                ]
            ], 200));
        }
        $comment->update([
            'content' => $req->content
        ]);
        return (new CommentsResource($comment))->pesan("Comment success diubah");
    }

    public function delete($id)
    {
        $user = Auth::user()->id;
        $comment = Comment::where('id', $id)->where('id_user', $user)->first();
        if (!$comment) {
            throw new HttpResponseException(response([
                "errors" => [
                    'code' => 404,
                    'message' => 'Comment Tidak Ditemukan'
                ]
            ], 200));
        }
        $comment->delete();
        return response()->json(['message' => 'Komentar Berhasil Dihapus'])->setStatusCode(200);
    }
}
