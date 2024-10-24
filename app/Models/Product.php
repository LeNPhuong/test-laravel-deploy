<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'product';

    protected $fillable = [
        'cate_id', 'name', 'price', 'sale', 'img',
        'quantity', 'description', 'made', 'active'
    ];
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'description' => $this->description,
            // Thêm các trường khác nếu cần
        ];
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
}
