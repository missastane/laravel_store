<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\User\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.delivery-province.index', compact('provinces'));
    }

    public function search(Request $request)
    {
        $provinces = Province::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('name')->get();
        return view('admin.market.delivery-province.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.market.delivery-province.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یء-ي ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $province = Province::create($inputs);
        if($province)
        {
            return redirect()->route('admin.market.delivery-province.index')->with('swal-success', 'استان ' . $province->name . ' با موفقیت افزوده شد');
        }
        else{
            return redirect()->route('admin.market.delivery-province.create')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }

    public function edit(Province $province)
    {
        return view('admin.market.delivery-province.edit', compact('province'));
    }


    public function cities(Province $province)
    {
        return view('admin.market.delivery-province.city.index', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|max:120|min:2|regex:/^[ا-یء-ي ]+$/u',
            'g-recaptcha-response' => 'recaptcha',
        ]);
        $inputs = $request->all();
        $update = $province->update($inputs);
        if($update)
        {
            return redirect()->route('admin.market.delivery-province.index')->with('swal-success', 'استان ' . $province->name . ' با موفقیت ویرایش شد');
        }
        else{
            return redirect()->route('admin.market.delivery-province.edit', $province->id)->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }


    public function destroy(Province $province)
    {
       
        $result = $province->delete();
        if($result)
        {
            return redirect()->route('admin.market.delivery-province.index')->with('swal-success', 'استان ' . $province->name . ' با موفقیت حذف شد');
        }
        else{
            return redirect()->route('admin.market.delivery-province.index')->with('swal-error', 'عملیات با خطا مواجه شد. لطفا دوباره امتحان کنید');

        }
    }
}
