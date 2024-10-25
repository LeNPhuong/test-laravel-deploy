<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id','status_id', 'voucher_id','total_price'
    ];
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
