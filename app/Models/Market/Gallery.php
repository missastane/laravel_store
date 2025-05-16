<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Gallery extends Model
{
    use HasFactory;

    protected $casts = ['image' => 'array'];
    protected $fillable = ['name', 'image', 'product_id'];

    protected $table = 'product_images';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
