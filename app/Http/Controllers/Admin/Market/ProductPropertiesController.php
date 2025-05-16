<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\CategoryValue;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class ProductPropertiesController extends Controller
{
    public function properties(Product $product)
    {
        $category_attributes = CategoryAttribute::where('category_id', $product->category->id)->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.product.properties.index', compact('category_attributes', 'product'));
    }

    public function search(Request $request, Product $product)
    {
        $category_attributes = CategoryAttribute::where('category_id', $product->category->id)->where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.product.properties.index', compact('category_attributes', 'product'));
    }

    public function storeProperties(Product $product, Request $request)
    {
        $request->validate([
            'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'unit' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['category_id'] = $product->category->id;
        $attribute = CategoryAttribute::create($inputs);
        $category_attributes = CategoryAttribute::where('category_id', $product->category->id)->orderBy('name')->get();
        return to_route('admin.market.product.properties', ['product' => $product, 'category_attributes' => $category_attributes])->with('swal-success', 'ویژگی با موفقیت افزوده شد');
    }

    public function updateProperties(Product $product, CategoryAttribute $attribute, Request $request)
    {
        $request->validate([
            'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'unit' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['category_id'] = $attribute->category_id;
        $attribute->update($inputs);
        $category_attributes = CategoryAttribute::where('category_id', $product->category->id)->orderBy('name')->get();
        return to_route('admin.market.product.properties', ['product' => $product, 'category_attributes' => $category_attributes])->with('swal-success', 'ویژگی با موفقیت بروززسانی شد');
    }
    public function propertyValues(Product $product, CategoryAttribute $attribute)
    {
        return view('admin.market.product.properties.values', compact('attribute', 'product'));
    }

    public function storePropertyValue(Product $product, CategoryAttribute $attribute, Request $request)
    {
        $request->validate([
            'value' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,،::. ]+$/u',
            'price_increase' => 'required|regex:/^[0-9\.]+$/u',
            'type' => 'required|numeric|in:1,2',
            'g-recaptcha-response' => 'recaptcha',

        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $attribute->id;
        $value = CategoryValue::create($inputs);
        return to_route('admin.market.product.properties.values', ['product' => $product, 'attribute' => $attribute])->with('swal', 'مقدار با موفقیت افزوده شد');
    }



    public function updatePropertyValue(CategoryValue $value, Request $request)
    {
        $request->validate([
            'value' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,،::. ]+$/u',
            'price_increase' => 'required|regex:/^[0-9\.]+$/u',
            'type' => 'required|numeric|in:1,2',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $value->product_id;
        $product = Product::find($inputs['product_id']);
        $inputs['category_attribute_id'] = $value->category_attribute_id;
        $attribute = CategoryAttribute::find($inputs['category_attribute_id']);
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $value->update($inputs);
        return to_route('admin.market.product.properties.values', ['product' => $product, 'attribute' => $attribute])->with('swal', 'مقدار با موفقیت بروزرسانی شد');

    }
}
