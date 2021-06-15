<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublishRequest extends FormRequest
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
            'category' => ['required', 'max:9'],
            'under_category'=>['required','max:255'],
            'address'=>['required','max:500'],
            'title'=>['required','max:255'],
            'description'=>['required','max:10000'],
            'price'=>['required','max:9'],
            'image.*' => ['required','mimes:jpeg,png,jpg,bmp'],
        ];
    }
}
