<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    // use HasFactory;
    public $table = "order_status";


    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'updated_at',
        'created_at',
        'deleted_at'
    ];


    public function order()
    {
        return $this->hasMany(Order::class,'order_status_id');
    }
}
