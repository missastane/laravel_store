<?php

namespace App\Models\User;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['name', 'description', 'status'];
    protected $cascadeDeletes = ['roles'];

    protected $dates = ['deleted_at'];
   

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
