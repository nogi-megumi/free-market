<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userImage = $user->profile->user_image ?? null;

        $tab = $request->query('tab');
        if ($tab === 'buy') {
            $items = $user->profile->purchases;
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

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new Profile();

        $profile->fill($request->only(['user_image', 'postcode', 'address', 'building']));
        $profile->user_id = $user->id;
        $profile->updateImage($request);
        $profile->save();

        $user->name = $request->name;
        $user->save();
        return redirect('/mypage');
    }
}
