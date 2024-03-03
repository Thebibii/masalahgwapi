<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $data = Post::with(['user'])->withCount(['comment'])->orderBy('created_at', 'DESC')->get();
        return new PostResourceCollection($data, true, 'Data Berhasil Diambil');
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            throw new HttpResponseException(response([
                "errors" => [
                    'code' => 404,
                    'message' => 'Postingan Tidak Ditemukan'
                ]
            ], 404));
        }

        $post->delete();

        return response()->json(['message' => 'Postingan Berhasil Dihapus'])->setStatusCode(200);
    }

    public function getPostUser()
    {
        $user = Auth::user()->id;
        $data = Post::with(['user'])->where("id_user", $user)->orderBy('created_at', 'DESC')->get();

        return new PostResourceCollection($data, true, 'Data Berhasil Diambil');
    }

    public function store(PostStoreRequest $req)
    {
        $req->validated();
        $post = Post::create([
            'content' => $req->content,
            'anonymous' => $req->anonymous,
            'id_user' => Auth::user()->id,
        ]);

        $post->loadCount('comment');
        $post->load('user');

        return new PostResource($post);
    }

    public function update(PostStoreRequest $req, $id)
    {

        try {
            $req->validated();

            $data = Post::findOrFail($id);
            $data->update([
                'content' => $req->content
            ]);

            $data->load('user');

            return new PostResource($data);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'errors' => [
                    'code' => 404,
                    'message' => 'Data Tidak Ditemukan'
                ]
            ], 404);
        }
    }

    public function detail($id)
    {
        $find = Post::with(['user', 'comment'])->withCount('comment')->where('id', $id)->first();
        if (!$find) {
            throw new HttpResponseException(response([
                "errors" => [
                    'code' => 404,
                    'message' => 'Postingan Tidak Ditemukan'
                ]
            ], 404));
        }
        return (new PostResource($find))->pesan("Succees");
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $post = Post::where('id', $id)->where('id_user', $user->id)->first();

        if (!$post) {
            throw new HttpResponseException(response([
                "errors" => [
                    'code' => 404,
                    'message' => 'Postingan Tidak Ditemukan'
                ]
            ], 200));
        }

        $post->delete();

        return response()->json(['message' => 'Postingan Berhasil Dihapus'])->setStatusCode(200);
    }
}
