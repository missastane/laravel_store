<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Brand;
use App\Models\Market\Category;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\Product;
use App\Models\Market\Product_Meta;
use App\Models\Market\ProductMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.product.index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.product.index', compact('products'));
    }

    public function status(Product $product)
    {
        $product->status = $product->status == 1 ? 2 : 1;
        $result = $product->save();
        if ($result) {
            if ($product->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $product->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $product->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function create()
    {
        $productCategories = Category::select('name', 'id')->orderBy('name')->get();
        $brands = Brand::select('persian_name', 'original_name', 'id')->orderBy('original_name')->get();
        $products = Product::select(['name', 'id'])->orderBy('name')->get();
        return view('admin.market.product.create', compact('productCategories', 'brands', 'products'));
    }

    public function store(ImageService $imageService, ProductRequest $request)
    {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market' . DIRECTORY_SEPARATOR . 'product');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.product.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }
        $inputs['tags'] = implode(",", array_values($inputs['tags']));
        $inputs['related_products'] = implode(",", array_values($inputs['related_products']));

        DB::transaction(function () use ($request, $inputs) {
            $product = Product::create($inputs);
            //    after making product we can to add meta_key and value
            if ($request->meta_value != null && $request->meta_key != null) {
                if (in_array('', $request->meta_value) != true) {
                    $metas = array_combine($request->meta_key, $request->meta_value);
                    foreach ($metas as $meta_key => $meta_value) {
                        $meta = ProductMeta::create([
                            'meta_key' => $meta_key,
                            'meta_value' => $meta_value,
                            'product_id' => $product->id
                        ]);
                    }
                }
            }

        });
        return redirect()->route('admin.market.product.index')->with('swal-success', ' محصول با موفقیت افزوده شد');

    }

    public function show()
    {

    }
    public function edit(Product $product)
    {
        $tags = explode(',', $product['tags']);
        $relatedProducts = explode(',', $product['related_products']);
        $productCategories = Category::select('name', 'id')->orderBy('name')->get();
        $brands = Brand::select('persian_name', 'original_name', 'id')->orderBy('original_name')->get();
        $products = Product::where('id', '!=', $product->id)->select(['name', 'id'])->orderBy('name')->get();
        return view('admin.market.product.edit', compact('productCategories','relatedProducts', 'brands', 'product', 'tags','products'));
    }


    public function update(Product $product, ImageService $imageService, ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            date_default_timezone_set('Iran');
            $realTimestamp = substr($request['published_at'], 0, 10);
            $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
            $inputs = $request->all();
    
            if ($request->hasFile('image')) {
                if (!empty($product->image)) {
                    $imageService->deleteDirectoryAndFiles($product->image['directory']);
                }
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market' . DIRECTORY_SEPARATOR . 'product');
                $result = $imageService->createIndexAndSave($request->file('image'));
    
                if ($result === false) {
                    return redirect()->route('admin.market.product.edit', $product->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');
                
                }
                $inputs['image'] = $result;
            } else {
                if (isset($inputs['currentImage']) && !empty($product->image)) {
                    $image = $product->image;
                    $image['currentImage'] = $inputs['currentImage'];
                    $inputs['image'] = $image;
                }
            }
    
          
            if ($inputs['category_id'] != $product->category_id) {
                $product->values()->delete();
            }
    
            $inputs['tags'] = implode(",", array_values($inputs['tags']));
            $inputs['related_products'] = implode(",", array_values($inputs['related_products']));
    
            
            $product->update($inputs);
    
            
            if (!empty($request->meta_value) && !empty($request->meta_key) && count($request->meta_key) == count($request->meta_value)) {
                // dd($request->meta_value);
                $newMetas = array_combine($request->meta_key, $request->meta_value);
                $existingMetas = $product->metas()->pluck('meta_value', 'meta_key')->toArray();
               
                foreach ($newMetas as $metaKey => $metaValue) {
                    if (isset($existingMetas[$metaKey])) {
                        
                        if ($existingMetas[$metaKey] !== $metaValue) {
                            ProductMeta::where('product_id', $product->id)
                                ->where('meta_key', $metaKey)
                                ->update(['meta_value' => $metaValue]);
                                
                        }
                        unset($existingMetas[$metaKey]); 
                    } else {
                        
                        ProductMeta::create([
                            'meta_key' => $metaKey,
                            'meta_value' => $metaValue,
                            'product_id' => $product->id
                        ]);
                        

                    }
                }
    

                // if (!empty($existingMetas)) {
                //     ProductMeta::where('product_id', $product->id)
                //         ->whereIn('meta_key', array_keys($existingMetas))
                //         ->delete();

                // }
            } else {
                return redirect()->route('admin.market.product.edit', $product->id)->with('swal-error', 'فیلد ویژگی ها نمی تواند خالی باشد. در صورت عدم نیاز آن را حذف نمایید');
            }
    
            DB::commit();
            return redirect()->route('admin.market.product.index')->with('swal-success', 'محصول ' . $product->name . ' با موفقیت ویرایش شد');
    
        
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.market.product.edit', [$product->id])->with('swal-error', 'خطا در بروزرسانی رخ داد.. لطفا مجددا تلاش کنید');
        
        }
    }
    // public function update(Product $product, ImageService $imageService, ProductRequest $request)
    // {
    //     date_default_timezone_set('Iran');
    //     $realTimestamp = substr($request['published_at'], 0, 10);
    //     $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
    //     $inputs = $request->all();
    //     if ($request->hasFile('image')) {

    //         if (!empty($product->image)) {
    //             $imageService->deleteDirectoryAndFiles($product->image['directory']);
    //         }

    //         $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market' . DIRECTORY_SEPARATOR . 'product');
    //         $result = $imageService->createIndexAndSave($request->file('image'));

    //         if ($result === false) {
    //             return redirect()->route('admin.market.product.edit', $product->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

    //         }
    //         $inputs['image'] = $result;
    //     } else {
    //         if (isset($inputs['currentImage']) && !empty($product->image)) {
    //             $image = $product->image;
    //             $image['currentImage'] = $inputs['currentImage'];
    //             $inputs['image'] = $image;
    //         }
    //     }
    //     if($inputs['category_id'] != $product->category_id)
    //     {
    //         $product->values()->delete();
    //     }
    //     $inputs['tags'] = implode(",", array_values($inputs['tags']));
    //     $inputs['related_products'] = implode(",", array_values($inputs['related_products']));

    //     DB::transaction(function () use ($request, $inputs, $product) {
    //         $product->update($inputs);
    //         if ($request->meta_value != null && $request->meta_key != null) {
    //             if (in_array('', $request->meta_value) != true) {

    //                 if ($product->metas()->get()->toArray() != null) {
    //                     ProductMeta::where('product_id', $product->id)->forceDelete();
    //                     $new_metas = array_combine($request->meta_key, $request->meta_value);

    //                     foreach ($new_metas as $meta_key => $meta_value) {
    //                         $new_meta = ProductMeta::create([
    //                             'meta_key' => $meta_key,
    //                             'meta_value' => $meta_value,
    //                             'product_id' => $product->id
    //                         ]);
    //                     }

    //                 } else {
    //                     $new_metas = array_combine($request->meta_key, $request->meta_value);
    //                     foreach ($new_metas as $meta_key => $meta_value) {
    //                         $new_meta = ProductMeta::create([
    //                             'meta_key' => $meta_key,
    //                             'meta_value' => $meta_value,
    //                             'product_id' => $product->id
    //                         ]);
    //                     }
    //                 }
    //             }
    //         } else {
    //             return redirect()->route('admin.market.product.edit', $product->id)->with('swal-error', 'فیلد ویژگی ها نمی تواند خالی باشد. در صورت عدم نیاز آن را حذف نمایید');
    //         }

    //     });
    //     return redirect()->route('admin.market.product.index')->with('swal-success', 'محصول ' . $product->name . ' با موفقیت ویرایش شد');
    // }

    public function destroy(Product $product)
    {
        $result = $product->delete();
        if ($result) {
            return redirect()->route('admin.market.product.index')->with('swal-success', 'محصول ' . $product->name . ' با موفقیت حذف شد');
        } 
        else {
            return redirect()->route('admin.market.product.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function deleteMeta(ProductMeta $meta)
    {
        $result = $meta->forceDelete();
        if ($result) {
            return response()->json([
                'status' => true,
                'checked' => true,
                'message' => 'ویژگی با موفقیت حذف شد'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

   
}
