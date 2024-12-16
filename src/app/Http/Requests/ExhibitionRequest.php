<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'item_name'=>['required'],
            'description'=>['required','max:255'],
            'item_image'=>['required','image','mimes:jpeg,png'],
            'categories'=>['required'],
            'condition_id'=>['required'],
            'price'=>['required', 'integer','numeric','min:0']
        ];
    }
}
