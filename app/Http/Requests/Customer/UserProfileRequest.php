<?php

namespace App\Http\Requests\Customer;

use App\Rules\NationalCode;
use App\Rules\UniquePhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
            'first_name' => 'sometimes|required|max:120|min:2|regex:/^[ا-یa-zA-Z\-ء-ي ]+$/u',
            'last_name' => 'sometimes|required|max:120|min:2|regex:/^[ا-یa-zA-Z\-ء-ي ]+$/u',
            'email' => 'sometimes|required|email|unique:users,email',
            'mobile'=> ['sometimes','required','min:10','max:13',new UniquePhoneNumber],
            'national_code'=> ['sometimes','required','unique:users,national_code', new NationalCode()]
        ];
    }
}
