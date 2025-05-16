<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\StoreRequest;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Log;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.store.index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.store.index', compact('products'));
    }

    public function addToStore(Product $product)
    {
        return view('admin.market.store.add-to-store', compact('product'));
    }
    public function store(StoreRequest $request, Product $product)
    {
        $product->marketable_number += $request->marketable_number;
        $product->save();
        Log::info("receiver => {$request->receiver}, deliverer => {$request->deliverer}, description => {$request->description}, add => {$request->marketable_number}");
        return redirect()->route('admin.market.store.index')->with('swal-success', 'موجودی محصول ' . $product->name . ' با موفقیت افزایش یافت');
    }

   
    public function edit(Product $product)
    {
        return view('admin.market.store.edit', compact('product'));
    }
    public function update(Product $product,Request $request)
    {
        $validated = $request->validate([
            'marketable_number'=>'required|numeric',
            'sold_number'=>'required|numeric',
            'frozen_number'=>'required|numeric',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $update = $product->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.store.index')->with('swal-success', 'موجودی محصول ' . $product->name . ' با موفقیت اصلاح شد');
        }
        else{
            return redirect()->route('admin.market.store.edit', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

   
}
