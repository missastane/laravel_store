<?php

namespace App\Models\User;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;
    protected $cascadeDeletes = ['cities'];

    protected $dates = ['deleted_at'];
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }
    protected $fillable = ['name'];
}
