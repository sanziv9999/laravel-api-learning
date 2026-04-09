<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(): void{
    Route::post('/logout', [AuthController::class, 'logout']);

    //blog api
    Route::post('/add/post', [PostController::class, 'addNewPost']);
    //edit approach 1
    Route::patch('/edit/post', [PostController::class, 'editPost']);

    //edit approach 2
    Route::patch('/edit/post/{id}', [PostController::class, 'editPostById']);

    //getAllPosts
    Route::get('/all/posts', [PostController::class, 'getAllPosts']);

    //delete post by id
    Route::delete('/delete/post/{id}', [PostController::class, 'deletePostById']);

});



