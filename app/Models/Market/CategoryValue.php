<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryValue extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['value', 'product_id', 'category_attribute_id', 'type'];
    protected $cascadeDeletes = ['cartItemSelectedAttributes', 'orderItemSelectedAttributes'];

    protected $dates = ['deleted_at'];
    public function orderItemSelectedAttributes()
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);
    }
    public function cartItemSelectedAttributes()
    {
        return $this->hasMany(CartItemSelectedAttribute::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(CategoryAttribute::class, 'category_attribute_id');
    }
}
