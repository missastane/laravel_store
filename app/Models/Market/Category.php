<?php

namespace App\Models\Market;

use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable, SoftDeletes,CascadeSoftDeletes;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }
    protected $cascadeDeletes = ['children', 'attributes', 'products'];

    protected $dates = ['deleted_at'];


    protected $casts = ['image' => 'array'];
    protected $fillable = ['name', 'description', 'slug', 'image', 'status', 'tags', 'parent_id', 'show_in_menu'];

    protected $table = 'product_categories';

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id')->with('children');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

}
