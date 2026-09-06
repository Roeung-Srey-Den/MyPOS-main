<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "products";
    protected $fillable = [
        'pro_name',
        'pro_price',
        'cate_id',
        'pro_pic',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cate_id');
    }
    public function category()
{
    return $this->belongsTo(Category::class, 'cate_id');
}

}
