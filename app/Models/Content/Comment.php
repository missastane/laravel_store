<?php

namespace App\Models\Content;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['children'];

    protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id')->with('parent');
    }
    public function children()
    {
        return $this->hasMany($this, 'parent_id', 'id')->with('children');
    }

    protected $fillable = ['body', 'parent_id', 'author_id', 'commentable_id', 'commentable_type', 'approved', 'status'];
}
