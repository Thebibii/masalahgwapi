<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

Route::get('/users', [AdminController::class, 'getAllUser'])->middleware('auth:sanctum');
Route::post('/register', [UsersController::class, 'store'])->name('store');
Route::get('/user', [UsersController::class, 'getUser'])->name('getUser')->middleware('auth:sanctum');
Route::post('/user', [UsersController::class, 'updateUser'])->middleware('auth:sanctum');
Route::get("/user/{name}/detail", [UsersController::class, 'profileUser'])->middleware("auth:sanctum");

Route::get('/post/{id}/detail',  [PostController::class, 'detail'])->name('posts.detail')->middleware('auth:sanctum');

Route::get('/posts',  [PostController::class, 'index'])->name('posts.index')->middleware('auth:sanctum');
Route::post('/post', [PostController::class, 'store'])->name('posts.store')->middleware('auth:sanctum');
Route::get('/posts/user',  [PostController::class, 'getPostUser'])->middleware('auth:sanctum');
Route::patch('/post/{id}/update', [PostController::class, 'update'])->name('posts.update')->middleware('auth:sanctum');
Route::delete('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.destroy')->middleware('auth:sanctum');

Route::delete('/posts/{id}/delete', [PostController::class, 'deletePost'])->middleware('auth:sanctum');

Route::post('/comment/{id}/create', [CommentController::class, 'store'])->middleware('auth:sanctum');
Route::post('/comment/{id}/update', [CommentController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/comment/{id}/delete', [CommentController::class, 'delete'])->middleware('auth:sanctum');

Route::get("/notifikasi", [NotifikasiController::class, 'index'])->middleware('auth:sanctum');
Route::post("/notifikasi/{id}/update", [NotifikasiController::class, 'update'])->middleware('auth:sanctum');

Route::post("/login", [LoginController::class, 'store'])->name("login");
Route::delete("/logout", [LoginController::class, 'destroy'])->name("logout")->middleware('auth:sanctum');
