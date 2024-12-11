<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function condition()
    {
        return $this->belongsTo(Conditon::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
