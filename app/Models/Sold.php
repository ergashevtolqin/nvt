<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;
    protected $table='sold';
    protected $fillable=[
        'number',
        'medicine_id',
        'user_id',
        'order_id',
        'price_product'
    ];
}
