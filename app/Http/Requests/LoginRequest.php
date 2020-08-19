<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class LoginRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages(){ 
        return[
            'email.required' => 'البريد الالكتروني مطلوب.',
            'email.email' => ' ادخل بريد الالكتروني صالح.',
            'password.required' => 'كلمه المرور مطلوبه.',    
        ];
    }
}
