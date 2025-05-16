<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['order_id', 'product_id', 'product_object', 'amazing_sale_id', 'amazing_sale_object', 'amazing_sale_discount_amount', 'number', 'final_product_price', 'final_total_price', 'color_id', 'guarantee_id'];
    protected $cascadeDeletes = ['orderItemSelectedAttributes'];

    protected $dates = ['deleted_at'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderItemSelectedAttributes()
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function amazingSale()
    {
        return $this->belongsTo(AmazingSale::class);
    }

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }

    
}
