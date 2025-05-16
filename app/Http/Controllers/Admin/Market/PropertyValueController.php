<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryValueRequest;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\CategoryValue;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{
    public function index(CategoryAttribute $attribute)
    { 
        return view('admin.market.property.value.index', compact( 'attribute'));
    }


    public function create(CategoryAttribute $attribute)
    { 
        return view('admin.market.property.value.create', compact( 'attribute'));
    }


    public function store(CategoryValueRequest $request, CategoryAttribute $attribute)
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value,'price_increase'=>$request->price_increase]);
        $inputs['category_attribute_id'] = $attribute->id;
        $value = CategoryValue::create($inputs);
        if ($value) {
            return redirect()->route('admin.market.property-value.index', $attribute->id)->with('swal-success', 'مقدار جدید برای ' . $attribute->name . ' با موفقیت ثبت شد');
        } else {
            return redirect()->route('admin.market.property-value.create', $attribute->id) . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function edit(CategoryAttribute $attribute, CategoryValue $value)
    { 
        return view('admin.market.property.value.edit', compact( 'attribute', 'value'));
    }

    public function update(CategoryValueRequest $request, CategoryAttribute $attribute, CategoryValue $value)
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value,'price_increase'=>$request->price_increase]);
        $inputs['category_attribute_id'] = $attribute->id;
        $update = $value->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.property-value.index', $attribute->id)->with('swal-success', 'مقدار ' . $attribute->name . ' با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.property-value.edit',['attribute'=> $attribute->id, 'value'=> $value->id] ) . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy( CategoryAttribute $attribute, CategoryValue $value)
    {
        $result = $value->delete();
        if ($result) {
            return redirect()->route('admin.market.property-value.index', $attribute->id)->with('swal-success', 'مقدار ' . $attribute->name . ' با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.market.property-value.index', $attribute->id ) . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

}
