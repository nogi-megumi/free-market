<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);


        $userImage = $user->profile->user_image ?? null;
        $items = Item::all();
        return view('profile', compact('userImage', 'items'));
    }

    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile ?? null;
        return view('profile_edit', compact('profile', 'user'));
    }

    public function update(ProfileRequest $request)
    {
        // 郵便番号のバリデートに半角数字を設定するか
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
    public function getParchase()
    {
        // 
    }
    public function getExhibition()
    {
        // 
    }
}
