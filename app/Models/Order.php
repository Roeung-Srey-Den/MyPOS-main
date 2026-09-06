<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = [
        'customer_id',
        'subtotal',
        'tax',
        'note',
        'status',
        'total',
        'shift_id',
        'user_id',
        'table_number_id'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function tableNumber()
    {
    return $this->belongsTo(Table::class);
    }

}
