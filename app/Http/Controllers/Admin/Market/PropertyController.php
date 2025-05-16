<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryAttributeRequest;
use App\Models\Market\Category;
use App\Models\Market\CategoryAttribute;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $category_attributes = CategoryAttribute::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.property.index', compact('category_attributes'));
    }

    public function search(Request $request)
    {
        $category_attributes = CategoryAttribute::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.property.index', compact('category_attributes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.market.property.create', compact('categories'));
    }
    public function store(CategoryAttributeRequest $request)
    {
        $inputs = $request->all();
        $attribute = CategoryAttribute::create($inputs);
        if ($attribute) {
            return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم ' . $attribute->name . ' با موفقیت ثبت شد');
        } else {
            return redirect()->route('admin.market.property.create') . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

  
    public function edit(CategoryAttribute $attribute)
    {
        $categories = Category::all();
        return view('admin.market.property.edit', compact('attribute', 'categories'));
    }
    public function update(CategoryAttribute $attribute, CategoryAttributeRequest $request)
    {
        $inputs = $request->all();
        $update = $attribute->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم ' . $attribute->name . ' با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.property.edit', $attribute->id) . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(CategoryAttribute $attribute)
    {
        $result = $attribute->delete();
        if ($result) {
            return redirect()->route('admin.market.property.index')->with('swal-success', 'فرم ' . $attribute->name . ' با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.market.property.index') . with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    
    }
}
