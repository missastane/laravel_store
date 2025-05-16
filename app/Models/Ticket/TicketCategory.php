<?php

namespace App\Models\Ticket;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketCategory extends Model
{
    use HasFactory,SoftDeletes,CascadeSoftDeletes;

   protected $fillable = ['name', 'status'];
   protected $dates = ['deleted_at'];
   protected $cascadeDeletes = ['tickets'];
   public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
