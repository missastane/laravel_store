<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryAttribute extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['name', 'type', 'unit','category_id'];
    protected $cascadeDeletes = ['cartItemSelectedAttributes', 'values', 'orderItemSelectedAttributes'];

    protected $dates = ['deleted_at'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItemSelectedAttributes()
    {
        return $this->hasMany(OrderItemSelectedAttribute::class);

    }
    public function cartItemSelectedAttributes()
    {
        return $this->hasMany(CartItemSelectedAttribute::class);
    }
    public function values()
    {
        return $this->hasMany(CategoryValue::class);
    }
}
