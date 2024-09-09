 <?php 

namespace App\Http\Controllers;

use App\Http\Requests\LikeRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\LikeResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\File;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FileManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
//    protected $fileManager;

//    public function __construct(FileManager $fileManager)
//    {
//        $this->fileManager = $fileManager;
//    }

    public function index()
    {
        $posts = Post::with(['user', 'tags', 'files', 'likedUsers'])->paginate(12);
        return PostResource::collection($posts);

    }



    public function show(Post $post)
    {
        return new PostResource($post->load(['user', 'tags', 'files', 'likedUsers','comments.replies']));
    }

    public function store(PostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'user_id' => Auth::id()
        ]);


        //این خط تک های ارسال شده در درخواست را با پست جدید همگام سازی میکند
        $post->tags()->sync($request->tags);

        if ($request->hasFile('files'))
            foreach ($request->file('files') as $file) {

                $fileName = uniqid() . '.' . $file->extension();

                Storage::putFileAs("posts/$post->id", $file, $fileName);

                $post->files()->create([
                    'mime_type' => $file->extension(),
                    'size' => $file->getSize() / 1024,
                    'path' => "storage/posts/$post->id/$fileName",
                ]);
            }

        return $this->successResponse($post);
    }



    public function updatePost(PostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
        ]);
        $post->tags()->sync($request->tags);
        return $this->successResponse(new PostResource($post->load(['user', 'tags', 'files'])));
    }

    public function updateDeleteFile(Request $request)
    {
// دریافت شناسه فایل از درخواست
        $file_id = $request['file_id'];
//        return $this->successResponse($file_id);

// پیدا کردن فایل در دیتابیس
        $file = File::where('id', $file_id)->first();
//        return $this->successResponse($file->path);

        if ($file) {
// حذف فایل از سیستم فایل
            Storage::delete($file->path);
            $file->delete();
            return $this->successResponse('file deleted');
        }
        else {
            return $this->errorResponse('file not deleted');
        }
    }

    public function updateAddFile(Request $request)
    {
        $post = Post::where('id', $request->input('post_id'))->first();

        if ($post && $request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->extension();
            Storage::putFileAs("storage/posts/$post->id", $file, $fileName);

            $post->files()->create([
                'mime_type' => $file->extension(),
                'size' => $file->getSize() / 1024,
                'path' => "storage/posts/$post->id/$fileName",
            ]);

            return $this->successResponse('add file');
        }
        else {
            return $this->errorResponse('file not created');
        }
    }


    public function destroy(Post $post)
    {
        $post->tags()->detach();

        foreach ($post->files as $file) {

            Storage::delete($file->path);

            $file->delete();
        }

        $post->delete();

        return $this->successResponse('deleted successfully');

    }
    public function like(LikeRequest $likeRequest)
    {
        $userId = $likeRequest['user_id'];

        $post_id = $likeRequest['post_id'];
        $post = Post::where('id', $post_id)->first();


        $likedUser = $post->likedUsers()->where('user_id', $userId)->exists();

        if ($likedUser) {
            $post->likedUsers()->where('user_id', $userId)->detach();
            return $this->successResponse('unliked');
        }
        else {
            $post->likedUsers()->attach(['user_id' => $userId]);
            return $this->successResponse('liked');
        }

    }



    public function tag(Request $request)
    {
        $tags = Tag::all();
        return $this->successResponse(TagResource::collection($tags));
    }
}

