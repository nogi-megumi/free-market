<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;

class ExhibitionController extends Controller
{
    public function create()
    {
        return view('exhibition');
    }
    public function store(Request $request)
    {

        // $image = $request->file('item_image');
        // $path = $image->store('public/images');

        // $model = new Item;
        // $model->item_image = $path;
        // $model->save();

        // return redirect()->route('index');
    }
}
