<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        // if(!$request){
        $address=auth()->user()->profile;
        // }else{
        // $address= $request->only('postcode', 'address', 'building');
        // }
        $data = [
            'item' => $item,
            'address'=>$address
        ];
        // dd($data);

        return view('purchase',$data);
    }
    public function store(Item $item)
    {
        return redirect('/');
    }
    public function edit(Item $item)
    {
        $address = auth()->user()->profile;
        $data = [
            'item' => $item,
            'address' => $address
        ];
        return view('address',$data);
    }
    public function update(Item $item,Request $request)
    {
        $address=$request->only('postcode','address','building');
        $data = [
            'item' => $item,
            'address' => $address
        ];
        // dd($data);

        // return view('purchase',$data);
        return redirect()->route('purchase.show',$data);
    }
}
