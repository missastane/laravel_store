<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.category.index', compact('categories'));
    }

    public function search(Request $request)
    {
        
        $categories = Category::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::select(['name', 'id'])->get();
        return view('admin.market.category.create', compact('categories'));
    }

    public function store(ImageService $imageService, CategoryRequest $request)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market'. DIRECTORY_SEPARATOR .'category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.category.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $category = Category::create($inputs);
        if($category)
        {
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته ' . $category->name . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.market.category.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function status(Category $category)
    {
        $category->status = $category->status == 1 ? 2 : 1;
        $result = $category->save();
        if ($result) {
            if ($category->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $category->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $category->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function showInMenu(Category $category)
    {
        $category->show_in_menu = $category->show_in_menu == 1 ? 2 : 1;
        $result = $category->save();
        if ($result) {
            if ($category->show_in_menu == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'امکان نمایش در منو برای ' . $category->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'امکان نمایش در منو برای ' . $category->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }


    public function edit(Category $category)
    {
        $tags = explode(',', $category['tags']);
        $productCategories = Category::where('id', '!=', $category->id)->select(['name', 'id'])->get();
        return view('admin.market.category.edit', compact('tags', 'category','productCategories'));
    }

    public function update(Category $category,ImageService $imageService, CategoryRequest $request)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty($category->image)) {
                $imageService->deleteDirectoryAndFiles($category->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market'. DIRECTORY_SEPARATOR .'category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.category.edit', [$category->id])->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        }
    else {
        if (isset($inputs['currentImage']) && !empty($category->image)) {
            $image = $category->image;
            $image['currentImage'] = $inputs['currentImage'];
            $inputs['image'] = $image;
        }
    }
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $update = $category->update($inputs);
        if($update)
        {
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته ' . $category->name . '  با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.market.category.edit', $category->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    public function destroy(Category $category)
    {
        $result = $category->delete();
        if($result)
        {
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته ' . $category->name . '  با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.market.category.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
