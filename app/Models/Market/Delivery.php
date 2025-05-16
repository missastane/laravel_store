<?php

namespace App\Models\Market;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $table = 'delivery';
    protected $cascadeDeletes = ['orders'];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected $fillable = ['name', 'amount', 'delivery_time', 'delivery_time_unit', 'status'];
}
