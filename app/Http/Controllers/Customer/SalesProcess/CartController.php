<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Market\CartItem;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart()
    {
        if (Auth::check()) {
            $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->with('product:id,name,image,slug,related_products', 'color:id,color_name', 'guarantee:id,name')->simplePaginate(15);
            $cartItemIds = $cartItems->pluck('product_id')->toArray();

            $relatedProductIds = $cartItems->flatMap(function ($item) {
                return $item->product->related_products ?
                    explode(',', $item->product->related_products) : [];
            })->unique()->values()->toArray();
            // dd($relatedProductIds);
            $relatedProducts = Product::whereIn('id', $relatedProductIds)
            ->whereNotIn('id', $cartItemIds)->with('category:id,name', 'brand:id,persian_name')->get();
            return view('customer.sales-process.cart', compact('cartItems', 'relatedProducts'));
        } else {
            return redirect()->route('auth.customer.login-register-form')->with('toast-error', 'کاربر گرامی، جهت مشاهده سبد خرید ابتدا باید وارد حساب خود شوید');
        }
    }

    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'number.*' => 'numeric|min:1|max:5'
        ]);
        $inputs = $request->all();
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
        foreach ($cartItems as $cartItem) {
            if (isset($inputs['number'][$cartItem->id])) {
                $cartItem->update(['number' => $inputs['number'][$cartItem->id]]);
            }
        }
        return redirect()->route('customer.sales-process.address-and-delivery');
    }

    public function addToCart(Product $product, Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guarantee' => 'nullable|exists:guarantees,id',
                'number' => ['numeric', 'min:1', "max:$product->marketable_number"],
            ]);

            $cartItems = CartItem::where('product_id', $product->id)->where('user_id', auth()->user()->id)->get();
            if (!isset($request->color)) {
                $request->color = null;
            }
            if (!isset($request->guarantee)) {
                $request->guarantee = null;
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->color_id == $request->color && $cartItem->guarantee_id == $request->guarantee) {
                    if ($cartItem->number != $request->number) {
                        $cartItem->update(['number' => $request->number]);
                    }
                    return back()->with('toast-error', 'محصول از قبل در سبد خرید شما وجود داشته است');
                }
            }

            $inputs = [];
            $inputs['color_id'] = $request->color;
            $inputs['guarantee_id'] = $request->guarantee;
            $inputs['user_id'] = auth()->user()->id;
            $inputs['product_id'] = $product->id;
            $inputs['number'] = $request->number;
            $newCartItem = CartItem::create($inputs);

            return back()->with('toast-success', 'محصول با موفقیت به سبد خرید افزوده شد');
        } else {
            return redirect()->route('auth.customer.login-register-form');
        }
    }

    public function removeFromCart(CartItem $cartItem)
    {
        if ($cartItem->user_id === Auth::user()->id) {
            $cartItem->delete();
        }
        return back()->with('toast-success', $cartItem->product->name . ' از سبد خرید شما پاک شد');
    }

}
