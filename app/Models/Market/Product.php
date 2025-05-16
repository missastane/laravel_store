<?php

namespace App\Models\Market;

use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Content\Comment;
use Nagy\LaravelRating\Traits\Rateable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable, CascadeSoftDeletes, Rateable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['name']
            ]
        ];
    }

    protected $casts = ['image' => 'array'];

    protected $cascadeDeletes = ['orderItems','cartItems', 'metas', 'colors', 'images', 'values', 'guarantees', 'amazingSales', 'comments'];

    protected $dates = ['deleted_at'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function metas()
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function images()
    {
        return $this->hasMany(Gallery::class);
    }

    public function values()
    {
        return $this->hasMany(CategoryValue::class);
    }

    public function attributes()
    {
        return $this->hasManyThrough(CategoryAttribute::class, CategoryValue::class);
    }
    public function guarantees()
    {
        return $this->hasMany(Guarantee::class);
    }

    public function amazingSales()
    {
        return $this->hasMany(AmazingSale::class);
    }
    public function comments()
    {
        return $this->morphMany('App\Models\Content\Comment', 'commentable');
    }

    public function activeAmazingSale()
    {
        return $this->amazingSales()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->where('status', 1)->first();
    }
    public function activeComments()
    {
        return $this->comments()->where('approved', 1)->where('parent_id', null)->get();
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user');
    }

    public function compares()
    {
        return $this->belongsToMany(Compare::class);
    }
    protected $fillable = ['name', 'introduction', 'view', 'slug', 'image', 'status', 'tags','related_products', 'length', 'width', 'height', 'weight', 'price', 'marketable', 'sold_number', 'frozen_number', 'marketable_number', 'category_id', 'brand_id', 'published_at'];
}
