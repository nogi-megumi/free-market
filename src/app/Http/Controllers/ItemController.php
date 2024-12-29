<?php

namespace App\Http\Controllers;

use App\Models\Item;
use GuzzleHttp\RetryMiddleware;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

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
    public function show(Item $item){
        
        $data=[
            'item'=>$item
        ];
        // dd($data);
        return view('item_detail',$data);
    }
}
