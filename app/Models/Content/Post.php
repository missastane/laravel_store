<?php

namespace App\Models\Content;

use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content\PostCategory;

class Post extends Model
{
    use HasFactory,Sluggable, SoftDeletes,CascadeSoftDeletes;

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => ['title']
            ]
        ];
    }
    protected $cascadeDeletes = ['comments'];

    protected $dates = ['deleted_at'];

    protected $casts = ['image' => 'array'];
    protected $fillable = ['title', 'summary', 'slug', 'image', 'status', 'tags', 'body', 'commentable', 'published_at', 'post_category_id', 'author_id'];

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class,'post_category_id');
    }

    

    public function user()
    {
       
        return $this->belongsTo(User::class,'author_id ');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Content\Comment', 'commentable');
    }
}
