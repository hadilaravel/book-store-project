<?php

namespace Modules\Book\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
                'title' => 'required|string|min:3|max:190',
                'price' => 'required',
                'status' => 'required|numeric|in:0,1',
                'image' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
                'description' => 'required|string|min:3',
            ];
        } else {
            return [
                'title' => 'required|string|min:3|max:190',
                'status' => 'required|numeric|in:0,1',
                'price' => 'required',
                'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
                'description' => 'required|string|min:3',
            ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
