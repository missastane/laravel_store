<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Post;
use App\Models\Content\PostCategory;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    function __construct()
    {
        // operators can only see edit page(method)
        // $this->middleware('role:admin')->only('index');
        // $this->middleware('role:operator')->only('edit');
        // $this->middleware('can:read-category')->only('index');
        // $this->authorizeResource(PostCategory::class, 'postCategory'); first model, second route model binding parameter
        
    }
    public function index()
    {

        // $user = auth()->user();
        // if($request->user()->can('read-category'))
        // {
        $postCategories = PostCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.content.category.index', compact('postCategories'));
        // }
        // else{
        //     abort(403,'you not allowed to access this page');
        // }

        // if($request->user()->cannot('read-category')){}


    }
    public function search(Request $request)
    {
        $postCategories = PostCategory::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.content.category.index', compact('postCategories'));
    }
    public function create()
    {
        return view('admin.content.category.create');
    }

    public function store(PostCategoryRequest $request, ImageService $imageService)
    {

        // $this->authorize('create', PostCategory::class);
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            // $result = $imageService->save($request->file('image'));
            $result = $imageService->createIndexAndSave($request->file('image'));

        }
        if ($result === false) {
            return redirect()->route('admin.content.category.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

        }
        $inputs['image'] = $result;


        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $postCategory = PostCategory::create($inputs);
        if ($postCategory) {
            return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته ' . $postCategory->name . ' با موفقیت افزوده شد');
        }
        return redirect()->route('admin.content.category.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');


    }
    public function status(PostCategory $postCategory)
    {
        $postCategory->status = $postCategory->status == 1 ? 2 : 1;
        $result = $postCategory->save();
        if ($result) {
            if ($postCategory->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $postCategory->name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $postCategory->name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(PostCategory $postCategory)
    {
        $tags = explode(',', $postCategory['tags']);
        return view('admin.content.category.edit', compact(['postCategory', 'tags']));
    }

    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService)
    {
        // $this->authorize('update', $category);
        // authorize return a http response + error code

        // if(!Gate::allows('update-postCategory', $postCategory)){
        // abort(403);
        // }
        
        $inputs = $request->all();
        if ($request->hasFile('image')) {

            if (!empty($postCategory->image)) {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.category.edit', $postCategory->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($postCategory->image)) {
                $image = $postCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }


        $inputs['tags'] = implode(",", array_values($inputs['tags']));
        $result = $postCategory->update($inputs);
        if ($result) {
            return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته ' . $postCategory->name . ' با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.content.category.edit', $postCategory->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }

    }

    public function destroy(PostCategory $postCategory, ImageService $imageService)
    {
     
        $result = $postCategory->delete();
        if ($result) {
            return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.content.category.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
