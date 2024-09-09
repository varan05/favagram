<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function model()
    {
        return $this->morphTo();
    }

// رابطه با کامنتهای پاسخ

    public function replies()
    {
        return $this->morphMany(Comment::class, 'model');
    }

}
