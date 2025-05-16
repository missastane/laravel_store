<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\SettingRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Setting\Setting;
use Database\Seeders\SettingSeeder;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        if($setting === null)
        {
            $default = new SettingSeeder();
            $default->run();
            $setting = Setting::first();
        }
        return view('admin.setting.index', compact('setting'));
    }
    public function edit()
    {
        $setting = Setting::first();
        $keywords = explode(',', $setting['keywords']);
        return view('admin.setting.edit', compact(['setting', 'keywords']));
    }

    public function update(SettingRequest $request, ImageService $imageService)
    {
       
        $setting = Setting::first();
        $inputs = $request->all();
        if ($request->hasFile('icon')) {
            
            if (!empty($setting->icon)) {
                $imageService->deleteImage($setting->icon);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('icon');
            $icon = $imageService->save($request->file('icon'));

            if ($icon === false) {
                return redirect()->route('admin.setting.edit')->with('swal-error', 'بارگذاری آیکن با خطا مواجه شد');

            }
            $inputs['icon'] = $icon;
        }
        
            if (isset($inputs['icon']) && !empty($setting->icon)) {
                $icon = $setting->icon;
                $inputs['icon'] = $icon;
            }
        
        if ($request->hasFile('logo')) {

            if (!empty($setting->logo)) {
                $imageService->deleteImage($setting->logo);
            }

            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('logo');
            $logo = $imageService->save($request->file('logo'));

            if ($logo === false) {
                return redirect()->route('admin.setting.edit')->with('swal-error', 'بارگذاری لوگو با خطا مواجه شد');

            }
            $inputs['logo'] = $logo;
        }
        
            if (isset($inputs['logo']) && !empty($setting->logo)) {
                $logo = $setting->logo;
                $inputs['logo'] = $logo;
            }
       
        $inputs['keywords'] = implode(",", array_values($inputs['keywords']));
    //    dd($inputs['icon'].' '.$inputs['logo']);
        $result = $setting->update($inputs);
        if($result)
        {
        return redirect()->route('admin.setting.index')->with('swal-success', 'تنظیمات با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.setting.edit')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
