<?php

namespace App\Models\Ticket;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = ['subject', 'description', 'author', 'reference_id', 'ticket_id', 'priority_id', 'category_id', 'seen', 'status', 'user_id'];

    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['children', 'ticketFiles'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(TicketAdmin::class, 'reference_id');
    }

    public function parent()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(Ticket::class, 'ticket_id')->with('children');
    }

    public function ticketFile()
    {
        return $this->hasOne(TicketFile::class, 'ticket_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }
}
