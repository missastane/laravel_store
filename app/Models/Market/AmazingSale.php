<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazingSale extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    
    protected $fillable = ['product_id','percentage', 'status', 'start_date', 'end_date'];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    protected $cascadeDeletes = ['orderItems'];

    protected $dates = ['deleted_at'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
