<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

//    public function index()
//    {
//// دریافت همه کامنتها به همراه والد (پست یا کامنت) و پاسخهای کامنتها
//
//        $comments = Comment::with(['replies'])
//            ->orderBy('created_at', 'desc')
//            ->get();
//        return $this->successResponse($comments);
//    }

    public function store(Request $request)
    {

// اعتبارسنجی دادههای ورودی
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'post_id' => 'nullable|exists:posts,id',
            'comment_id' => 'nullable|exists:comments,id',
            'body' => 'string|max:500',
        ]);

// ایجاد یک کامنت جدید
        $comment = new Comment();
        $comment->user_id = $validatedData['user_id'];
        $comment->body = $validatedData['body'];

        $input= $request->all();
// بررسی اینکه کامنت برای پست است یا برای کامنت دیگر

        if ($input['model_type'] === 'post') {
            $comment->model_type = Post::class;
        } elseif ($input['model_type'] === 'comment') {
            $comment->model_type = Comment::class;
        }

        $comment->model_id = $input['model_id'];

// ذخیره کامنت
        $comment->save();
        return $this->successResponse('commented successfuly');

    }
}
