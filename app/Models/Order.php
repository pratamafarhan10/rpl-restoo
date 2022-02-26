<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'food_id', 'total_order', 'total_price', 'is_delivered', 'is_ready_to_be_paid', 'order_code', 'is_paid', 'is_done', 'table_number', 'price_qty', 'total_delivered', 'customer_name', 'payment_type', 'payment_token', 'payment_url'];

    protected $with = ['food'];

    public function food(){
        return $this->belongsTo(Food::class);
    }
}
