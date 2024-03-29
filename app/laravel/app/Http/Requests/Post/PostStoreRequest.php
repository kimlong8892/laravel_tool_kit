<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array {
        return [
            'name' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'description' => 'required',
            'content' => 'required',
            'status' => 'required',
            'slug' => 'required',
            'category_id' => 'required'
        ];
    }
}
