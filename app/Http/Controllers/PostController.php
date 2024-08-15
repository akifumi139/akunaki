<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function home()
    {
        $posts = Post::with('images')
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
}
