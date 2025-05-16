<?php

namespace App\Models\User;

use App\Models\Market\Order;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['name', 'province_id'];
    protected $cascadeDeletes = ['addresses'];

    protected $dates = ['deleted_at'];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'city_id');
    }
   
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
