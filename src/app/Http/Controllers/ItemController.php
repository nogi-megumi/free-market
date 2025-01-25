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
        dd($request);
        $items = [];
        $user = auth()->user();
        $tab = $request->get('tab', 'recommend');

        if ($tab === 'mylist') {
            if (!$user) {
                return redirect('/login');
            }

            if ($request->has('keyword')) {
                $items = Item::whereHas('favorites', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->where('item_name', 'LIKE', "%{$request->keyword}%")->get();
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
        $param = [
            'tab' => $tab,
            'items' => $items,
            'keyword' => $request->keyword
        ];
        return view('item_index', $param);
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
        $user = auth()->user();
        $tab = $request->get('tab', 'recommend');
        // dd($request);

        if ($request->has('keyword')) {
            if ($tab === 'recommend') {
                $items = Item::where('item_name', 'LIKE', "%{$request->keyword}%")->get();
            } elseif ($tab === 'mylist' && $user) {
                $items = Item::whereHas('favorites', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->where('item_name', 'LIKE', "%{$request->keyword}%")->get();
            }
            session()->put('search_items', $items);
            session()->put('search_keyword', $request->keyword);
        } else {
            $items = session()->get('search_items', []);
            $request->merge(['keyword' => session()->get('search_keyword')]);
        }
        $param = [
            'tab' => $tab,
            'items' => $items,
            'keyword' => $request->keyword
        ];
        return view('item_index', $param);
    }
}
