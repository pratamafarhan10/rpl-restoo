<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_number', 'customer_name', 'id'];

    protected $primaryKey = 'id'; // or null

    public $incrementing = false;

}
