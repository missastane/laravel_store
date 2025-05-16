<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Models\User\City;
use App\Models\User\Province;
use Illuminate\Http\Request;

class ProfileAddressController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        $cities = City::all();
        return view('customer.profile.addresses', compact('cities', 'provinces'));
    }
}
