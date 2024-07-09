<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_amount',
        'total_amount',
        'created_at'
    ];

    public function order() {
        return $this->belongsTo(Orders::class);
    }

    public function product() {
        return $this->belongsTo(Products::class);
    }
}
