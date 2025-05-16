<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Gallery;
use App\Models\Market\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.market.product.gallery.index', compact('product'));
    }

    public function search(Request $request,Product $product)
    {
        $images = Gallery::where('product_id', $product->id)->where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        $request->session()->put('images', $images);
        return view('admin.market.product.gallery.index', compact('product'))->with(['images'=> $images]);
    }

    public function create(Product $product)
    {
        return view('admin.market.product.gallery.create', compact('product'));
    }

    public function store(Request $request, Product $product, ImageService $imageService)
    {
        $validated = $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $product->id);
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.gallery.create', $product->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }
        $gallery = Gallery::create($inputs);
        if ($gallery) {
            return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-success', ' تصویر گالری با موفقیت افزوده شد');
        } else {
            return redirect()->route('admin.market.gallery.create', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

    public function edit(Product $product, Gallery $gallery)
    {
        return view('admin.market.product.gallery.edit', compact('product', 'gallery'));
    }

    public function update(Request $request, Product $product, Gallery $gallery, ImageService $imageService)
    {
        $validated = $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,، ]+$/u',
            'image' => 'image|mimes:png,jpg,jpeg,gif',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        if ($request->hasFile('image')) {

            if (!empty($product->image)) {
                $imageService->deleteDirectoryAndFiles($gallery->image['directory']);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market' . DIRECTORY_SEPARATOR . 'product' . DIRECTORY_SEPARATOR . 'gallery' . DIRECTORY_SEPARATOR . $product->id);
            $result = $imageService->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.market.gallery.edit', ['product' => $product->id, 'gallery' => $gallery->id])->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }
        $update = $gallery->update($inputs);
        if ($update) {
            return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-success', ' تصویر با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.market.gallery.edit', ['product' => $product->id, 'gallery' => $gallery->id])->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }
    public function destroy(Product $product, Gallery $gallery, ImageService $imageService)
    {
        if (!empty($product->image)) {
            $imageService->deleteDirectoryAndFiles($product->image['directory']);
        }
        $result = $gallery->delete();
        if ($result) {
            return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-success', ' تصویر با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.market.gallery.index', $product->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا دوباره امتحان کنید');
        }
    }

}
