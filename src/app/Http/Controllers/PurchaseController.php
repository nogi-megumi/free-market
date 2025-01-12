<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;

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
    public function store(Item $item)
    {
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
    public function update(Item $item, Request $request)
    {
        $request->validate([
            'postcode' => ['regex:/^[0-9]{3}-[0-9]{4}$/i'],
            'address' => ['required'],
            'building' => ['required'],
        ]);
        session(['temporary_address' => $request->only(['postcode', 'address', 'building'])]);
        return redirect()->route('purchase.show', $item);
    }
}
