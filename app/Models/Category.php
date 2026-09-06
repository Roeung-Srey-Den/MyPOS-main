<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = "category";
    protected $fillable = [
        'name'
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
