<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\BannerRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Content\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->simplePaginate(15);
        $positions = Banner::$positions;
        return view('admin.content.banner.index', compact('banners', 'positions'));
    }

    public function search(Request $request)
    {
        $banners = Banner::where('title', 'LIKE', "%" . $request->search . "%")->orderBy('title')->get();
        $positions = Banner::$positions;
        return view('admin.content.banner.index', compact('banners','positions'));
    }

    public function create()
    {
        $positions = Banner::$positions;
        return view('admin.content.banner.create', compact('positions'));
    }

    public function store(BannerRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));

        }
        if ($result === false) {
            return redirect()->route('admin.content.banner.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

        }
        $inputs['image'] = $result;

        $banner = Banner::create($inputs);
        if ($banner) {
            return redirect()->route('admin.content.banner.index')->with('swal-success', 'بنر ' . $banner->title . ' با موفقیت افزوده شد');
        }
        return redirect()->route('admin.content.banner.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');


    }
    public function status(Banner $banner)
    {
        $banner->status = $banner->status == 1 ? 2 : 1;
        $result = $banner->save();
        if ($result) {
            if ($banner->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $banner->title . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $banner->title . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(Banner $banner)
    {
        $positions = Banner::$positions;
        return view('admin.content.banner.edit', compact('banner', 'positions'));
    }

    public function update(BannerRequest $request, Banner $banner, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {

            if (!empty($postCategory->image)) {
                $imageService->deleteImage($banner->image['directory']);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'banner');
            $result = $imageService->save($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.content.banner.edit', $banner->id)->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($banner->image)) {
                $image = $banner->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }


        $result = $banner->update($inputs);
        if ($result) {
            return redirect()->route('admin.content.banner.index')->with('swal-success', 'بنر ' . $banner->title . ' با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.content.banner.edit', $banner->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }

    }

    public function destroy(Banner $banner, ImageService $imageService)
    {
        $result = $banner->delete();
        if ($result) {
            return redirect()->route('admin.content.banner.index')->with('swal-success', 'بنر با موفقیت حذف شد');
        } else {
            return redirect()->route('admin.content.banner.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
