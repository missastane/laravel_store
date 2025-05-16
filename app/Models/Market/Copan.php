<?php

namespace App\Models\Market;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Copan extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $cascadeDeletes = ['orders'];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    protected $fillable = ['code', 'amount', 'amount_type', 'discount_ceiling', 'type', 'status', 'start_date', 'user_id', 'end_date'];

}
