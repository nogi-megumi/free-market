<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab');

        if ($tab === 'mylist') {
            if (!$user) {
                return redirect('/login');
            } else {
                $items = Item::whereHas('favorites', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->get();
            }
        } else {
            $items = Item::when($user, function ($query) use ($user) {
                return $query->where('user_id', '!=', $user->id);
            })->get();
        }
        return view('item_index', compact('items', 'tab'));
    }

    public function show(Item $item)
    {
        $condition = Condition::find($item->condition_id);
        $comments = Comment::with('item')->where('item_id', $item->id)->get();
        $item['condition'] = $condition;
        $user = auth()->user();
        $isLiked = $user ? $user->favorites()->where('item_id', $item->id)->exists() : collect([]);
        $item['isLiked'] = $isLiked;
        $data = [
            'item' => $item,
            'comments' => $comments,
        ];
        return view('item_detail', $data);
    }

    public function like(Item $item)
    {
        $user = auth()->user();
        $isLiked = $user->favorites()->where('item_id', $item->id)->exists();
        if ($isLiked) {
            $user->favorites()->detach($item->id);
        } else {
            $user->favorites()->attach($item->id);
        }
        return back();
    }

    public function search(Request $request)
    {
        $items = Item::where('item_name', 'LIKE',"%{$request->keyword}%")->get();
        $tab = '';

        $param = [
            'tab' => $tab,
            'items' => $items
        ];
        return view('item_index', $param);
    }
}
