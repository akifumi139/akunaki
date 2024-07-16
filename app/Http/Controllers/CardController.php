<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;

class CardController extends Controller
{
    public function store(PostRequest $request)
    {
        $params = $request->params();
        Post::create($params);

        return to_route('top');
    }
}
