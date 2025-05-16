<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Product;
use App\Models\Market\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.market.product.color.index', compact('product'));
    }

    public function search(Request $request,Product $product)
    {
        $colors = ProductColor::where('product_id', $product->id)->where('color_name', 'LIKE', "%" . $request->search . "%")->orderBy('color_name')->get();
        $request->session()->put('colors', $colors);
        return view('admin.market.product.color.index', compact('product'))->with(['colors'=> $colors]);
    }
    public function create(Product $product)
    {
        return view('admin.market.product.color.create', compact('product'));
    }

    public function store(Request $request,Product $product)
    {
        $validated = $request->validate([
            'color_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'color' => 'required|max:120',
            'price_increase' => 'required|numeric',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        // dd($inputs);
        $color = ProductColor::create($inputs);
        if($color)
        {
            return redirect()->route('admin.market.product-color.index', $product->id)->with('swal-success', ' رنگ با موفقیت افزوده شد');
        }
        else
        {
            return redirect()->route('admin.market.product-color.create', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function status(ProductColor $color)
    {
        $color->status = $color->status == 1 ? 2 : 1;
        $result = $color->save();
        if ($result) {
            if ($color->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $color->color_name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $color->color_name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(Product $product, ProductColor $color)
    {
        return view('admin.market.product.color.edit', compact('product', 'color'));
    }

    public function update(Request $request,Product $product, ProductColor $color)
    {
        $validated = $request->validate([
            'color_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'color' => 'required|max:120',
            'price_increase' => 'required|numeric',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $update = $color->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.product-color.index', $product->id)->with('swal-success', ' رنگ با موفقیت ویرایش شد');
        }
        else
        {
            return redirect()->route('admin.market.product-color.edit', ['product'=> $product->id,'color'=> $color->id])->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function destroy(Product $product, ProductColor $color)
    {
        $result = $color->delete();
        if($result)
        {
            return redirect()->route('admin.market.product-color.index', $product->id)->with('swal-success', ' رنگ با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.market.product-color.index', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
}
