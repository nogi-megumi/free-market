<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userImage = $user->profile->user_image ?? null;
        $tab = $request->query('tab');
        if ($tab === 'buy') {
            $purchases = $user->purchases;
            $items = Item::whereHas('purchases', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } elseif ($tab === 'sell') {
            $items = $user->items;
        } else {
            $items = $user->items;
        }

        return view('profile', compact('userImage', 'items', 'tab'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? null;
        return view('profile_edit', compact('profile', 'user'));
    }

    public function update(ProfileRequest $request, AddressRequest $addressRequest)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();

        $profile->fill($request->only(['user_image']));
        $profile->fill($addressRequest->only(['postcode', 'address', 'building']));
        $profile->user_id = $user->id;
        $profile->updateImage($request);
        $profile->save();

        $user->name = $request->name;
        $user->save();
        return redirect('/mypage');
    }
}
