<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Item;
// use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function store(Item $item , CommentRequest $request)
    {
        $user=auth()->user()->id;
        Comment::create([
            'user_id'=>$user,
            'item_id'=>$item->id,
            'comment'=>$request->comment
        ]);
        return back();
    }
}
