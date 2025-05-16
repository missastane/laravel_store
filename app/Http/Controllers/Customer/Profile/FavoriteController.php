<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        return view('customer.profile.favorites');
    }

    public function remove(Product $product)
    {
        $user = auth()->user();
        $user->products()->detach($product->id);
        return back()->with('toast-success', 'محصول از لیست علاقه مندی پاک شد');
    }
}
