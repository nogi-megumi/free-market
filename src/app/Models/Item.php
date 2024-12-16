<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'condition_id',
        'item_image',
        'item_name',
        'description',
        'price',
        'brand',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id')->withTimestamps();
    }
}
