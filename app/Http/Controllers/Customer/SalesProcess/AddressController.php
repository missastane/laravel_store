<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\SalesProcess\AddressRequest;
use App\Http\Requests\Customer\SalesProcess\ChooseAddressAndDeliveryRequest;
use App\Models\Market\CartItem;
use App\Models\Market\CommonDiscount;
use App\Models\Market\Delivery;
use App\Models\Market\Order;
use App\Models\User\Address;
use App\Models\User\City;
use App\Models\User\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function addressAndDelivery()
    {
        // check profile info
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $provinces = Province::all();
        $cities = City::all();
        $deliveryMethods = Delivery::where('status', 1)->get();
        return view('customer.sales-process.address-and-delivery', compact('cartItems', 'provinces', 'cities', 'deliveryMethods'));
    }

    public function addAddress(AddressRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address = Address::create($inputs);
        return redirect()->back()->with('toast-success', 'آدرس جدید با موفقیت ثبت شد');

    }

    public function getCities(Province $province)
    {
        $cities = $province->cities;
        if ($cities != null) {
            return response()->json([
                'status' => true,
                'cities' => $cities
            ]);
        } else {
            return response()->json([
                'status' => false,
                'cities' => null
            ]);
        }
    }

    public function updateAddress(Address $address, AddressRequest $request)
    {
        $inputs = $request->all();
        $inputs['user_id'] = auth()->user()->id;
        $inputs['postal_code'] = convertArabicToEnglish($request->postal_code);
        $inputs['postal_code'] = convertPersianToEnglish($inputs['postal_code']);
        $address->update($inputs);
        return redirect()->back()->with('toast-success', 'آدرس با موفقیت ویرایش شد');
    }

    public function chooseAddressAndDelivery(ChooseAddressAndDeliveryRequest $request)
    {
        $user = auth()->user();

        // calculate price
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalFinalDiscountPriceWithNumber = 0;
        foreach ($cartItems as $cartItem) {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPriceWithNumber += $cartItem->cartItemFinalDiscount();
        }

        // calculate commonDiscount
        $commonDisount = CommonDiscount::where([['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($commonDisount) {
            $inputs['common_discount_id'] = $commonDisount->id;
            $inputs['common_discount_object'] = json_encode($commonDisount);
            $discountPercentagePrice = $totalFinalPrice * ($commonDisount->percentage / 100);
            if ($discountPercentagePrice > $commonDisount->discount_ceiling) {
                $discountPercentagePrice = $commonDisount->discount_ceiling;
            }
            if ($commonDisount != null && $totalFinalPrice >= $commonDisount->minimal_order_amount) {
                $finalPrice = $totalFinalPrice - $discountPercentagePrice;
            } else {
                $finalPrice = $totalFinalPrice;
            }
        } else {
            $discountPercentagePrice = 0;
            $finalPrice = $totalFinalPrice;
        }
        $delivery = Delivery::find($request->delivery_id);
        $address = Address::find($request->address_id);
        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $finalPrice;
        $inputs['order_discount_amount'] = $totalFinalDiscountPriceWithNumber;
        $inputs['order_common_discount_amount'] = $discountPercentagePrice;
        $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount'];
        $inputs['delivery_id'] = $request->delivery_id;
        $inputs['delivery_object'] = json_encode($delivery);
        $inputs['delivery_amount'] = $delivery->amount;
        $inputs['address_id'] = $request->address_id;
        $inputs['address_object'] = json_encode($address);
        $inputs['copan_id'] = null;
        $inputs['order_copan_discount_amount'] = null;
        $order = Order::updateOrCreate(
            ['user_id' => $user->id, 'order_status' => 0],
            $inputs
        );

        return redirect()->route('customer.sales-process.payment', compact('order'));
    }

}
