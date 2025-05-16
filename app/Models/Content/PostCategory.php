<?php

namespace App\Models\Content;

use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes, Sluggable, CascadeSoftDeletes;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name', 'id']
            ]
        ];
    }
    protected $cascadeDeletes = ['posts'];

    protected $dates = ['deleted_at'];
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id');
    }

    protected $casts = ['image' => 'array'];
    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags'];
}
