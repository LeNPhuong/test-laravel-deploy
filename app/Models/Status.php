<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';

    protected $fillable = [
        'text_status', // Hoặc các trường khác nếu có
    ];

    // Định nghĩa mối quan hệ với bảng Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
