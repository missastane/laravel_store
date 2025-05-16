<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Guarantee;
use App\Models\Market\Product;
use Illuminate\Http\Request;
use Session;

class ProductGuaranteeController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.market.product.guarantee.index', compact('product'));
    }

    public function search(Request $request,Product $product)
    {
        $guarantees = Guarantee::where('product_id', $product->id)->where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        $request->session()->put('guaurantee', $guarantees);
        return view('admin.market.product.guarantee.index', compact('product'))->with(['guaurantee'=> $guarantees]);
    }
    public function create(Product $product)
    {
        return view('admin.market.product.guarantee.create', compact('product'));
    }

    public function store(Request $request,Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'price_increase' => 'required|numeric',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        // dd($inputs);
        $guarantee = Guarantee::create($inputs);
        if($guarantee)
        {
            return redirect()->route('admin.market.product-guarantee.index', $product->id)->with('swal-success', ' گارانتی با موفقیت افزوده شد');
        }
        else
        {
            return redirect()->route('admin.market.product-guarantee.create', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function status(Guarantee $guarantee)
    {
        $guarantee->status = $guarantee->status == 1 ? 2 : 1;
        $result = $guarantee->save();
        if ($result) {
            if ($guarantee->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $guarantee->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $guarantee->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function edit(Product $product, Guarantee $guarantee)
    {
        return view('admin.market.product.guarantee.edit', compact('product', 'guarantee'));
    }

    public function update(Request $request,Product $product, Guarantee $guarantee)
    {
        $validated = $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'price_increase' => 'required|numeric',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        
        $inputs = $request->all();
       
        $inputs['product_id'] = $product->id;
        $update = $guarantee->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.product-guarantee.index', $product->id)->with('swal-success', ' گارانتی با موفقیت ویرایش شد');
        }
        else
        {
            return redirect()->route('admin.market.product-guarantee.edit', ['product'=> $product->id,'guarantee'=> $guarantee->id])->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function destroy(Product $product, Guarantee $guarantee)
    {
        $result = $guarantee->delete();
        if($result)
        {
            return redirect()->route('admin.market.product-guarantee.index', $product->id)->with('swal-success', ' گارانتی با موفقیت حذف شد');
        }
        else
        {
            return redirect()->route('admin.market.product-guarantee.index', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
}
