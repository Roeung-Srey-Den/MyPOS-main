<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'table_numbers';
    protected $fillable = ['table_name','is_occupied'];
}
