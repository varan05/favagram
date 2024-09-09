<?php
//
//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Model;
//
//class Post extends Model
//{
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
//
//    public function tags()
//    {
//        return $this->morphToMany(Tag::class, 'model', 'model_has_tags');//چند به چند
//    }
//
//    public function files()
//    {
//        return $this->morphMany(File::class, 'model');//یک به چند مدل پست میتواند چندین فایل داشته باشد و فایل ها میتوانند به فقط یک پست تعلق داشته باشند
//    }
//}
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    protected $fillable = ['title', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'model', 'model_has_tags');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function likedUsers()
    {
        return $this->morphToMany(User::class, 'model','model_has_likes');

    }
    public function getLikesCountAttribute()
    {
        return $this->likedUsers()->count();
    }

    public function likedByUser($userId)
    {
        return $this->likedUsers()->where('user_id', $userId)->exists();
    }



    public function comments()
    {
        return $this->morphMany(Comment::class, 'model');
    }


}
