<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CopanRequest;
use App\Models\Market\AmazingSale;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Copan;
use App\Models\Market\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function copan()
    {
        $copans = Copan::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.discount.copan.index', compact('copans'));
    }

    public function copanSearch(Request $request)
    {
        $copans = Copan::where('code', 'LIKE', "%" . $request->search . "%")->orderBy('id')->get();
        return view('admin.market.discount.copan.index', compact('copans'));
    }

    public function copanStatus(Copan $copan)
    {
        $copan->status = $copan->status == 1 ? 2 : 1;
        $result = $copan->save();
        if ($result) {
            if ($copan->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function copanCreate()
    {
        $users = User::all();
        return view('admin.market.discount.copan.create', compact('users'));
    }

    public function copanStore(CopanRequest $request)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['user_id'] = null;
        }
        $copan = Copan::create($inputs);
        if ($copan) {
            return redirect()->route('admin.market.discount.copan')->with('swal-success', ' کوپن با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.market.discount.copan.create')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }

    }
    public function copanEdit(Copan $copan)
    {
        $users = User::all();
        return view('admin.market.discount.copan.edit', compact('copan', 'users'));
    }

    public function copanUpdate(CopanRequest $request, Copan $copan)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        if($inputs['type'] == 0)
        {
            $inputs['user_id'] = null;
        }
        $update = $copan->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.discount.copan')->with('swal-success', ' کوپن با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.discount.copan.edit', $copan->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function copanDestroy(Copan $copan)
    {
        $result = $copan->delete();
        if ($result) {
            return redirect()->route('admin.market.discount.copan')->with('swal-success', ' کوپن با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.market.discount.copan')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function commonDiscount()
    {
        $commonDiscounts = CommonDiscount::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.discount.common-discount.index', compact('commonDiscounts'));
    }

    public function commonDiscountSearch(Request $request)
    {
        $commonDiscounts = CommonDiscount::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('title')->get();
        return view('admin.market.discount.common-discount.index', compact('commonDiscounts'));
    }

    public function commonDiscountStatus(CommonDiscount $commonDiscount)
    {
        $commonDiscount->status = $commonDiscount->status == 1 ? 2 : 1;
        $result = $commonDiscount->save();
        if ($result) {
            if ($commonDiscount->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function commonDiscountCreate()
    {
        return view('admin.market.discount.common-discount.create');
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        $commonDiscount = CommonDiscount::create($inputs);
        if ($commonDiscount) {
            return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', ' تخفیف عمومی با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.market.discount.commonDiscount.create')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function commonDiscountEdit(CommonDiscount $commonDiscount)
    {
        return view('admin.market.discount.common-discount.edit', compact('commonDiscount'));
    }
    public function commonDiscountUpdate(CommonDiscountRequest $request, CommonDiscount $commonDiscount)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        $update = $commonDiscount->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', ' تخفیف عمومی با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.discount.commonDiscount.edit', $commonDiscount->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function commonDiscountDestroy(CommonDiscount $commonDiscount)
    {
        $result = $commonDiscount->delete();
        if ($result) {
            return redirect()->route('admin.market.discount.commonDiscount')->with('swal-success', ' تخفیف عمومی با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.market.discount.commonDiscount')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function amazingSale()
    {
        $amazingSales = AmazingSale::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.discount.amazing-sale.index', compact('amazingSales'));
    }
    public function amazingSaleSearch(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%" . $request->search . "%")->get();
        $amazingSales = collect();
        foreach($products as $product)
       {
        if($product->amazingSales()->get()->toArray()){
        $amazingSales->push($product->amazingSales);
    }
       }
       $amazingSales = $amazingSales->first();
        return view('admin.market.discount.amazing-sale.index', compact('amazingSales'));
    }
    public function amazingSaleStatus(AmazingSale $amazingSale)
    {
        $amazingSale->status = $amazingSale->status == 1 ? 2 : 1;
        $result = $amazingSale->save();
        if ($result) {
            if ($amazingSale->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function amazingSaleCreate()
    {
        $products = Product::all();
        return view('admin.market.discount.amazing-sale.create', compact('products'));
    }

    public function amazingSaleStore(AmazingSaleRequest $request)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        $amazingSale = AmazingSale::create($inputs);
        if ($amazingSale) {
            return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' محصول با موفقیت به فروش شگفت انگیز افزوده شد');
        } else {
            return redirect()->route('admin.market.discount.amazingSale.create')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function amazingSaleEdit(AmazingSale $amazingSale)
    {
        $products = Product::all();
        return view('admin.market.discount.amazing-sale.edit', compact('amazingSale', 'products'));
    }
    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale)
    {
        date_default_timezone_set('Iran');
        $startDateTimestamp = substr($request['start_date'], 0, 10);
        $request['start_date'] = date("Y-m-d H:i:s", (int) $startDateTimestamp);
        $endDateTimestamp = substr($request['end_date'], 0, 10);
        $request['end_date'] = date("Y-m-d H:i:s", (int) $endDateTimestamp);
        $inputs = $request->all();
        $update = $amazingSale->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' محصول فروش شگفت انگیز با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.discount.amazingSale.edit', $amazingSale->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {
        $result = $amazingSale->delete();
        if ($result) {
            return redirect()->route('admin.market.discount.amazingSale')->with('swal-success', ' محصول با موفقیت از لیست فروش شگفت انگیز حذف شد');
        } else {
            return redirect()->route('admin.market.discount.amazingSale')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

}
