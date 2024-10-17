<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name', 'key', 'active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cate_id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'category_unit', 'category_id', 'unit_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($unit) {
            // Ẩn trường pivot khi lấy dữ liệu
            $unit->makeHidden(['active','created_at', 'updated_at']);
        });
    }
}
