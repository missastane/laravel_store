<?php

namespace App\Http\Controllers\Customer\Market;

use App\Http\Controllers\Controller;
use App\Models\Content\Comment;
use App\Models\Market\Category;
use App\Models\Market\Compare;
use App\Models\Market\Product;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class ProductController extends Controller
{
    // public function product(Product $product)
    // {
    //     $userIp = request()->getClientIp();
    //     $oldView = View::where('ip', $userIp)->where('viewable_type', Product::class)->where('viewable_id', $product->id)->first();
    //     if(!$oldView){
    //     View::createViewLog(Product::class,$product, $userIp);
    //     $product->increment('view');
    // }
    //     $relatedProduct = $product->related_products;
    //     $relatedProductIds = [];
    //     if ($relatedProduct != null) {
    //         $relatedProduct = explode(',', $relatedProduct);
    //         foreach ($relatedProduct as $intId) {
    //             array_push($relatedProductIds, $intId);
    //         }
    //     }

    //     $relatedProductIds = array_unique($relatedProductIds);
    //     $relatedProducts = [];
    //     foreach ($relatedProductIds as $id) {
    //         $related = Product::find($id);
    //         array_push($relatedProducts, $related);
    //     }
    //     // dd($relatedProduct);
    //     $values = $product->values->toArray();
    //     $names = $product->category->attributes->toArray();
    //     $category_attr_details = array_map(function ($value) use ($names) {
    //         $value_with_ids['category_attribute_id'] = $value['category_attribute_id'];
    //         $value_with_ids['values'] = json_decode($value['value'])->value;
    //         foreach (array_column($names, 'id') as $key => $id) {
    //             if ($id == $value_with_ids['category_attribute_id']) {
    //                 $value_with_ids['name'] = array_column($names, 'name')[$key];
    //                 $value_with_ids['unit'] = array_column($names, 'unit')[$key];
    //             }
    //         }
    //         return $value_with_ids;
    //     }, $values);
    //     $category_attr_details_group = [];
    //     if($category_attr_details != null){
    //     foreach ($category_attr_details as $group) {
    //         $category_attr_details_group[$group['name']][] = $group['values'] . ' ' . $group['unit'];
    //     }
    // }
    //     return view('customer.market.product.product', compact('product', 'relatedProducts', 'category_attr_details_group'));
    // }

    public function product(Product $product)
    {
        $userIp = request()->getClientIp();
        View::firstOrCreate(
            ['ip' => $userIp, 'viewable_type' => Product::class, 'viewable_id' => $product->id],
            ['ip' => $userIp, 'viewable_type' => Product::class, 'viewable_id' => $product->id]
        );
    
        if (!View::where('ip', $userIp)->where('viewable_type', Product::class)->where('viewable_id', $product->id)->exists()) {
            $product->increment('view');
        }
  
        $relatedProducts = Product::whereIn('id', explode(',', $product->related_products))->get();
    
        $categoryAttributes = $product->category->attributes->keyBy('id'); 
        $categoryAttrDetails = $product->values->map(function ($value) use ($categoryAttributes) {
            $attribute = $categoryAttributes[$value['category_attribute_id']] ?? null;
            return [
                'category_attribute_id' => $value['category_attribute_id'],
                'values' => json_decode($value['value'])->value,
                'name' => $attribute ? $attribute->name : null, 
                'unit' => $attribute ? $attribute->unit : null, 
            ];
        });

        $category_attr_details_group = $categoryAttrDetails->groupBy('name')->map(function ($group) {
            return $group->map(function ($item) {
                return $item['values'] . ' ' . ($item['unit'] ?? ''); 
            })->implode(', '); 
        });
        return view('customer.market.product.product', compact('product', 'relatedProducts', 'category_attr_details_group'));
    }
    
    public function addComment(Product $product, Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|max:1000|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,،\.?؟! ]+$/u'
        ]);
        $inputs['body'] = str_replace(PHP_EOL, '<br/>', $request->body);
        $inputs['author_id'] = Auth::user()->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = Product::class;
        $comment = Comment::create($inputs);
        if ($comment) {
            return redirect()->route('customer.market.product', $product)->with('toast-success', 'ثبت نظر با موفقیت انجام شد. پس تأیید مدیر سایت نمایش داده خواهد شد');
        } else {
            return back()->with('toast-error', 'ارسال نظر با خطا مواجه شد');
        }
    }

    public function addToFavorite(Product $product)
    {
        if (Auth::check()) {
            $product->users()->toggle(Auth::user()->id);
            if ($product->users->contains(Auth::user()->id)) {
                return response()->json([
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'status' => 2
                ]);
            }
        } else {
            return response()->json([
                'status' => 3
            ]);
        }
    }

    public function addRate(Product $product, Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);
        $productIds = auth()->user()->isUserPerchasedProduct($product->id);
        if (Auth::check() && $productIds->count() > 0) {
            $user = Auth::user();
            $user->rate($product, $validated['rating']);
            return back()->with('toast-success', 'امتیاز شما با موفقیت ثبت گردید');
        }
        return back()->with('toast-error', 'جهت ثبت امتیاز ابتدا باید محصول را خریداری نمایید');
    }




    public function compare(Product $product)
    {
        $products = [];
        array_push($products, $product);
        Session::put($product->id, $products);
        return view('customer.profile.compare-list', compact('product'));
    }

    public function addToCompare(Request $request, Product $product)
    {
        $oldProductIds = [];
        foreach ($request->oldProduct as $oldId) {
            array_push($oldProductIds, $oldId);
        }
        $products = [];
        $newProduct = Product::find($request->product);

        if (!in_array($request->product, $oldProductIds) && count($oldProductIds) < 4 && $product->category->id == $newProduct->category->id) {

            foreach ($oldProductIds as $id) {
                $oldProduct = Product::find($id);
                array_push($products, $oldProduct);
            }
            array_push($products, $newProduct);
            Session::put($product->id, $products);
            return redirect()->back()->with(compact('product'))->with(['data' => session($product->id)]);
        } else {
            return back()->with('toast-error', 'خطا');
        }
    }

    public function removeFromCompare(Request $request, Product $product)
    {
        $oldProductIds = [];
        foreach ($request->oldProducts as $oldId) {
            array_push($oldProductIds, $oldId);
        }
        $removeArrayKey = array_search($request->removedProduct, $oldProductIds);
        unset($oldProductIds[$removeArrayKey]);
        $oldProductIds = array_splice($oldProductIds, 0, count($oldProductIds));
        $products = [];
        foreach ($oldProductIds as $id) {
            $oldProduct = Product::find($id);
            array_push($products, $oldProduct);
        }
        if ($oldProductIds[0] == $product->id) {
            Session::put($product->id, $products);
            return to_route('customer.market.compare', $product)->with(['data' => session($product->id)]);
        } else {
            Session::put($oldProductIds[0], $products);
            return to_route('customer.market.compare', $product)->with(['data' => session($oldProductIds[0])]);
        }
    }
}
