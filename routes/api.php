<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;



Route::prefix('/membership')->group(function (){
    Route::prefix('/auth')->controller(MembershipController::class)->group(function (){
        Route::post('/sendcode', 'sendcode');
        Route::post('/confirmation', 'confirmation');
        Route::post('/login', 'login');

    });
});

Route::prefix('/post')->middleware('auth:sanctum')->group(function () {

    Route::get('/index', [PostController::class, 'index']);
    Route::post('/store', [PostController::class, 'store']);
    Route::get('/show/{post}', [PostController::class, 'show']);
    Route::post('/updatePost/{post}', [PostController::class, 'updatePost']);
    Route::post('/updatedeletefile', [PostController::class, 'updateDeleteFile']);
    Route::post('/updateaddfile', [PostController::class, 'updateAddFile']);
    Route::delete('destroy/{post}', [PostController::class, 'destroy']);
    Route::post('like', [PostController::class, 'like']);
    Route::get('tag', [PostController::class, 'tag']);
});

Route::prefix('/comment')->middleware('auth:sanctum')->group(function () {
//    Route::get('/index', [CommentController::class, 'index']);
    Route::post('/store', [CommentController::class, 'store']);

});
