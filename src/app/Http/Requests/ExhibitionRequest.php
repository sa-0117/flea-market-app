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
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'mimes:jpeg,png'],
            'categories' => ['required','array', 'min:1'],
            'condition' => ['required'],
            'listing_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages() {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明を255文字以内で入力してください',
            'image.required' => '画像をアップロードしてください',
            'image.mimes' => '拡張子が.jpegもしくは.pngで登録してください',
            'categories.required' => '商品のカテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'listing_price.required' => '価格を入力してください',
            'listing_price.numeric' => '価格を数字で入力してください',
            'listing_price.min' => '価格を0円以上で入力してください',
        ];
    }
}
