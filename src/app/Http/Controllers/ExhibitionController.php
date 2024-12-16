<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\CategoryItem;
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
        dd();
        $user_id = auth()->user()->id;
        $image = $request->file('item_image');
        $path = Storage::putFile('images', $image);

        $item =new Item([
            'user_id' => $user_id,
            'condition_id' => $request->condition_id,
            'item_name' => $request->item_name,
            'brand' => $request->brand,
            'detail' => $request->detail,
            'price' => $request->price
        ]
        );
        $item->item_image = $path;
        $item->save();

        // $item_categories = $request->categories;
        foreach($request->categories as $categoryId){
            CategoryItem::create([
                'item_id'=>$item->id,
                'category_id'=>$categoryId,
            ]);
        }
        // $item->categories()->attach($item_categories);
        return redirect()->route('index');
    }
}
