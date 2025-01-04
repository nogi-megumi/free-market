<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Condition;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
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
            }
            $items = isset($user->favorites) ? $user->favorites->map(function ($favorite) {
                return $favorite->item;
            }) : collect([]);
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
        $comments=Comment::with('item')->where('item_id',$item->id)->get();
        $item['condition'] = $condition;
        $data = [
            'item' => $item,
            'comments'=>$comments,
        ];
        return view('item_detail', $data);
    }

    public function like(Item $item)
    {
        $user = auth();
        if (!$user) {
            return redirect('/login');
        }
        $isLiked = $user->favorites('item_id', $item->id)->exists();
        if ($isLiked) {
            $user->favorites()->detach($item);
        } else {
            $user->favorites()->attach($item);
        }
        dd($isLiked);
        return back();
    }
    // public function delete(Item $item)
    // {
    //     $user = auth()->id();
    //     $favorite = Favorite::where($item->user_id, '=', $user)->get();
    //     if ($favorite) {
    //         $favorite->delete();
    //     }
    //     return back();
    // }
}
