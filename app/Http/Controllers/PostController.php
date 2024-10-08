<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class PostController extends Controller
{
    public function home()
    {
        $posts = Post::with(['images', 'pin'])
            ->orderByDesc('id')
            ->paginate(10);

        return
            response()
            ->json(
                $posts,
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }

    public function pins()
    {
        $posts = Post::with('images')
            ->orderByDesc('id')
            ->whereHas('pin', function ($query) {
                $query->whereNotNull('id');;
            })
            ->paginate(10);

        return
            response()
            ->json(
                $posts,
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }

    public function create(Request $request)
    {
        $request->validate([
            'image' => [
                'required_without:comment',
                'nullable',
                'image',
                // 'max:1024',
            ],
            'comment' => [
                'required_without:image',
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $post =  Post::create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        $this->uploadImage($post, $request);

        $post->load('images');

        return
            response()
            ->json(
                $post,
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }

    private function uploadImage(Post $post, $request): void
    {
        if (!$request->image) {
            return;
        }

        $tmpImagePath = $request->image->store('images', 'public');

        $accessPath = storage_path('app/public/' . $tmpImagePath);

        $manager = new ImageManager(Driver::class);
        $image = $manager->read($accessPath);


        $image->scaleDown(width: 2000);
        $image = $image->encode(new WebpEncoder(quality: 100));

        $pathInfo = pathinfo($tmpImagePath);
        $imagePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        $savePath =  storage_path('app/public/' . $imagePath);
        $image->save($savePath);

        PostImage::create([
            'filename' => $request->image->getClientOriginalName(),
            'path' => $imagePath,
            'post_id' => $post->id,
        ]);
    }

    public function delete(int $id)
    {
        $resultCount = Post::destroy($id);

        if ($resultCount == 0) {
            return
                response()
                ->json(
                    ['message' => '該当するデータが存在しません'],
                    404,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
        }

        return
            response()
            ->json(
                ["Success" => $resultCount],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }

    public function pin(int $id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return
                response()
                ->json(
                    ['message' => '該当するデータが存在しません'],
                    404,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
        }

        $pin = $post->pin();
        if (!$pin->exists()) {
            $pin->create([
                'user_id' => Auth::id(),
                'status' => true,
                'updated_at' => now(),
            ]);
        }

        return
            response()
            ->json(
                ["status" => 'ピン止め'],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }

    public function unpin(int $id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return
                response()
                ->json(
                    ['message' => '該当するデータが存在しません'],
                    404,
                    [],
                    JSON_UNESCAPED_UNICODE
                );
        }

        $pin = $post->pin();
        if ($pin->exists()) {
            $pin
                ->where('user_id', Auth::id())
                ->delete();
        }

        return
            response()
            ->json(
                ["status" => '解除'],
                200,
                [],
                JSON_UNESCAPED_UNICODE
            );
    }
}
