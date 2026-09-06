<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = "customers";
    protected $fillable = ['name','table_number','phone','address','order_type'];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function latestOrder()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }
}
