<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Symfony\Contracts\Service\Attribute\Required;


class RegisterRequest extends FormRequest
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
            'name'=>['required','string','max:255'],
            'email'=>['required', 'email', 'unique','max:255'],
            'password'=>['required', 'min:8', 'confirmed']
        ];
    }
    // public function messages()   
    // {         
    //     return [
    //         'name.required' => 'お名前を入力してください。',
    //     ];
    // }
}
