<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\User\City;
use App\Models\User\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function create(Province $province)
    {
        return view('admin.market.delivery-province.city.create', compact('province'));
    }

    public function search(Request $request,Province $province)
    {
        $cities = City::where('province_id', $province->id)->where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        $request->session()->put('cities', $cities);
        return view('admin.market.delivery-province.city.index', compact('province'))->with(['cities'=> $cities]);
    }

    public function store(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یء-ي ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $inputs['province_id'] = $province->id;
        $city = City::create($inputs);
        if($city)
        {
            return redirect()->route('admin.market.delivery-province.cities', $province->id)->with('swal-success', 'شهر ' . $city->name . ' با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.market.delivery-city.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }

    public function edit(City $city)
    {
        return view('admin.market.delivery-province.city.edit', compact('city'));
    }



    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یء-ي ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs['province_id'] = $city->province->id;
        $inputs = $request->all();
        $update = $city->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.delivery-province.cities', $city->province->id)->with('swal-success', 'شهر ' . $city->name . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.market.delivery-province.edit', $city->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }


    public function destroy(City $city)
    {
       
        $result = $city->delete();
        if($result)
        {
            return redirect()->route('admin.market.delivery-province.cities', $city->province->id)->with('swal-success', 'شهر ' . $city->name . ' با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.market.delivery-province.cities', $city->province->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
