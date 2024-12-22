<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(){
        $items=Item::all();
        return view('item_index',compact('items'));
    }
    public function getMylist(){
        // if(Auth::check()){

        // }
        // return route('login');
    }
}
