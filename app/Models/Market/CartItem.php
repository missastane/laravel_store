<?php

namespace App\Models\Market;

use App\Models\User;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $fillable = ['user_id', 'product_id', 'color_id', 'guarantee_id', 'number'];
    protected $cascadeDeletes = ['cartItemSelectedAttributes'];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function cartItemSelectedAttributes()
    {
        return $this->hasMany(CartItemSelectedAttribute::class);
    }
    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // price = ProductPrice + ColorPrice + GuaranteePrice
    public function cartItemProductPrice()
    {
        $guaranteePriceIncrease = empty($this->guarantee_id) ? 0 : $this->guarantee->price_increase;
        $colorPriceIncrease = empty($this->color_id) ? 0 : $this->color->price_increase;
        return $this->product->price + $guaranteePriceIncrease + $colorPriceIncrease;
    }

    // ProductDiscount = ProductPrice * (DiscountPercentage/100)

    public function cartItemProductDiscount()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $productDiscount = empty($this->product->activeAmazingSale()) ? 0 : $cartItemProductPrice * ($this->product->activeAmazingSale()->percentage / 100);
        return $productDiscount;
    }

    // number * (cartItemProductPrice - cartItemProductDiscount)
    public function cartItemFinalPrice()
    {
        $cartItemProductPrice = $this->cartItemProductPrice();
        $cartItemProductDiscount = $this->cartItemProductDiscount();
        $cartItemFinalPrice = $this->number * ($cartItemProductPrice - $cartItemProductDiscount);
        return $cartItemFinalPrice;
    }

    // number *  productDiscount
    public function cartItemFinalDiscount()
    {
        $productDiscount = $this->cartItemProductDiscount();
        return $this->number * $productDiscount;
    }

}
