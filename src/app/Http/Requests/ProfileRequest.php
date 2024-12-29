<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'user_image' => ['image', 'mimes:jpeg,png'],
            'postcode' => ['regex:/^[0-9]{3}-[0-9]{4}$/i']
        ];
    }
    public function messages()
    {
        return [
            'user_image.mimes' => '拡張子が.jpegもしくは.pngの画像を選択してください',
            'postcode.regex' => '郵便番号はハイフンを含む、半角数字で入力してください'
        ];
    }
}
