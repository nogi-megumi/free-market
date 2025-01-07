<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Profile;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        $user=auth()->user();
        $address=Profile::where('user_id',$user->id)->get();
        // dd($address);
        $data = [
            'item' => $item,
            'address'=>$address
        ];
        return view('purchase',$data);
    }
    public function store(Item $item)
    {
        return redirect('/');
    }
    public function edit(Item $item)
    {
        $user = auth()->user();
        $profile = Profile::where('user_id', $user->id)->get();
        $data = [
            'item' => $item,
            'profile' => $profile
        ];
        // dd($data);

        return view('address',$data);
    }
    public function update(Item $item)
    {
        return redirect()->route('purchase.show');
    }
}
