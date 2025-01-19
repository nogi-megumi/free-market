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
        // dd($items);
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
        $items = [];
        if ($request->has('keyword')) {
            $items = Item::where('item_name', 'LIKE', "%{$request->keyword}%")->get();
            session()->put('search_items', $items);
            session()->put('search_keyword', $request->keyword);
        } else {
            $items = session()->get('search_items', []);
            $request->merge(['keyword' => session()->get('search_keyword')]);
        }
        // $tab = $request->get('tab', 'recommend');
        $tab = $request->get('tab', '');
        $param = [
            'tab' => $tab,
            'items' => $items,
            'keyword' => $request->keyword
        ];
        return view('item_index', $param);
    }
}
