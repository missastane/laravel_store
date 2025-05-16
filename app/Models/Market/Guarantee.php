<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guarantee extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['name', 'product_id', 'price_increase', 'status'];
    protected $cascadeDeletes = ['orderItems'];

    protected $dates = ['deleted_at'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
