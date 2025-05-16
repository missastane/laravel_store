<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\BrandRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.brand.index', compact('brands'));
    }

    public function search(Request $request)
    {
        $brands = Brand::where('persian_name', 'LIKE', "%" . $request->search . "%")->orWhere('original_name', 'LIKE', "%" . $request->search . "%")->orderBy('persian_name')->get();
        return view('admin.market.brand.index', compact('brands'));
    }
    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.market.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request,ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market'. DIRECTORY_SEPARATOR .'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.market.brand.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['logo'] = $result;
        }
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $brand = Brand::create($inputs);
        if($brand)
        {
        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند ' . $brand->persian_name . '  با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.market.brand.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    /**
     * Display the specified resource.
     *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function status(Brand $brand)
    {
        $brand->status = $brand->status == 1 ? 2 : 1;
        $result = $brand->save();
        if ($result) {
            if ($brand->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت ' . $brand->persian_name . ' با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت ' . $brand->persian_name . ' با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }
    public function edit(Brand $brand)
    {
        $tags = explode(',', $brand['tags']);
        return view('admin.market.brand.edit', compact(['brand', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            if (!empty($brand->logo)) {
                $imageService->deleteDirectoryAndFiles($brand->logo['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'market'. DIRECTORY_SEPARATOR .'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.market.brand.create')->with('swal-error', 'بارگذاری عکس با خطا مواجه شد');

            }
            $inputs['logo'] = $result;
        }
    else {
        if (isset($inputs['currentImage']) && !empty($brand->logo)) {
            $logo = $brand->logo;
            $logo['currentImage'] = $inputs['currentImage'];
            $inputs['logo'] = $logo;
        }
    }
        $inputs['tags'] = implode(",", array_values($inputs['tags']));

        $update = $brand->update($inputs);
        if($update)
        {
        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند ' . $brand->persian_name . '  با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.market.brand.edit', $brand->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $result = $brand->delete();
        if($result)
        {
        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند ' . $brand->persian_name . '  با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.market.brand.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');
        }
    }
}
