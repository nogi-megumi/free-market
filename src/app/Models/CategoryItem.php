<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'item_id',
    ];
    public function user()
    {
        return $this->belongsTo(Item::class);
    }
    public function condition()
    {
        return $this->belongsTo(Category::class);
    }
}