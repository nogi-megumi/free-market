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
            'item_name' => ['required'],
            'description' => ['required', 'max:255'],
            'item_image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'integer', 'numeric', 'min:0']
        ];
    }
    public function messages()
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'description.required' =>
            '商品の説明を入力してください',
            'description.max' =>
            '商品の説明は255字以下で入力してください',
            'item_image.required' =>'商品画像をアップロードしてください',
            'item_image.mimes' => '.jpegもしくは.pngの画像をアップロードしてください',
            'categories.required' =>'カテゴリを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数字で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }
}
