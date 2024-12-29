<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_image',
        'postcode',
        'address',
        'building',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateImage(Request $request)
    {
        if ($request->hasFile('user_image')) {
            $this->deleteImage();
            $imagePath = $request->file('user_image')->store('public/images/');
            $this->user_image =
            basename($imagePath);
        }
        $this->save();
    }

    private function deleteImage()
    {
        if ($this->user_image) {
            Storage::delete('public/images' . $this->user_image);
        }
    }
}
