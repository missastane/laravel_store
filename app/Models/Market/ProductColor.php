<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColor extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['color_name','color', 'product_id', 'price_increase', 'status', 'frozen_number', 'sold_number', 'marketable_number'];
    protected $cascadeDeletes = ['orderItems'];

    protected $dates = ['deleted_at'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'color_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
