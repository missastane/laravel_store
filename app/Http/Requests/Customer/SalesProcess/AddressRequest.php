<?php

namespace App\Http\Requests\Customer\SalesProcess;

use App\Rules\PostalCode;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'province_id'=>'required|exists:provinces,id|numeric',
            'city_id'=>'required|exists:cities,id|numeric',
            'no'=>'required|',
            'unit'=>'required|',
            'postal_code'=>['required', new PostalCode()],
            'address'=>'required|max:300',
            'receiver'=>'sometimes',
            'recipient_first_name'=>'required_with:receiver,on|max:120',
            'recipient_last_name'=>'required_with:receiver,on|max:120',
            'mobile'=>'required_with:receiver,on',
        ];
    }

    public function attributes()
    {
        return[
            'province_id' => 'استان',
            'city_id' => 'شهر',
            'postal_code' => 'کد پستی',
            'address' => 'نشانی',
            'unit' => 'واحد',
            'no' => 'پلاک',
            'receiver' => 'گیرنده',
            'recipient_first_name' => 'نام گیرنده',
            'recipient_last_name' => 'نام خانواگی گیرنده',
            'mobile' => 'شماره موبایل',
        ];
    }
}
