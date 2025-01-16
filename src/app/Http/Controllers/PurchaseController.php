<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function show(Item $item)
    {
        $defaultAddress = auth()->user()->profile;
        $temporaryAddress = session('temporary_address', [
            'postcode' => $defaultAddress->postcode ?? '',
            'address' => $defaultAddress->address ?? '',
            'building' => $defaultAddress->building ?? '',
        ]);
        $data = [
            'item' => $item,
            'address' => $temporaryAddress
        ];
        return view('purchase', $data);
    }
    public function store(Item $item,PurchaseRequest $request)
    {
        $user=auth()->user();
        Purchase::create([
            'user_id'=>$user->id,
            'item_id'=>$item->id,
            'payment'=>$request->payment,
            'shipping_address'=>$request->shipping_address,
        ]);
        $item->status='売却済';
        $item->save();
        return redirect('/');
    }
    public function edit(Item $item)
    {
        $address = session('temporary_address', auth()->user()->profile);
        $data = [
            'item' => $item,
            'address' => $address
        ];
        return view('address', $data);
    }
    public function update(Item $item, AddressRequest $request)
    {
        session(['temporary_address' => $request->only(['postcode', 'address', 'building'])]);
        return redirect()->route('purchase.show', $item);
    }
}
