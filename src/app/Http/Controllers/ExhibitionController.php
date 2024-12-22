<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ExhibitionController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('exhibition', compact('categories', 'conditions'));
    }
    public function store(ExhibitionRequest $request)
    {
        $user_id = auth()->user()->id;
        $image = $request->file('item_image');
        $path = Storage::putFile('public/images', $image);

        $item = new Item(
            [
                'user_id' => $user_id,
                'condition_id' => $request->condition,
                'item_name' => $request->item_name,
                'brand' => $request->brand,
                'description' => $request->description,
                'price' => $request->price
            ]
        );
        $item->item_image = basename($path);
        $item->save();
        $item->categories()->attach($request->categories);
        return redirect('/');
    }
}
