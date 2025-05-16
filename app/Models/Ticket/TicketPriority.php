<?php

namespace App\Models\Ticket;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketPriority extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['tickets'];
    protected $fillable = ['name', 'status'];
}
