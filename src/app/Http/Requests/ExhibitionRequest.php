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
            'name' => ['required','string'],
            'explanation' => ['required','string','max:255'],
            'image' => ['required','image','mimes:jpeg,png'],
            'category_id' => ['required','integer','exists:categories,id'],
            'condition_id' => ['required','integer','exists:conditions,id'],
            'price' => ['required','integer','min:0']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'explanation.required' => '商品説明を入力してください',
            'explanation.max' => '商品説明は255文字以内で入力してください',
            'image.required' => '画像をアップロードしてください',
            'image.mimes' => '画像は.jpegもしくは.pngを選択してください',
            'category_id.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は0円以上で入力してください'
        ];
    }
}
