<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;


class CommentController extends Controller
{
    public function store(Item $item, CommentRequest $request)
    {
        $user = auth()->user();
        $item->comments()->create([
            'user_id' => $user->id,
            'comment' => $request->comment
        ]);
        return back();
    }
}
