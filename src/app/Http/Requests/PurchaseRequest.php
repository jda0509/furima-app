<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method_id' => ['required','integer','exists:payment_methods,id'],
            'address' => ['required','string']
        ];
    }

    public function messages(){
        return [
            'payment_method_id.required' => '支払い方法を選択してください',
            'address.required' => '配送先を入力してください'
        ];
    }
}
