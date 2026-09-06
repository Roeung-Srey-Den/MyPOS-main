<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashier extends Model
{
    protected $table = "user";
    protected $fillable = ['name','email','password','role'];
}
