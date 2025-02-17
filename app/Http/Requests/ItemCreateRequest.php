<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:250',
            'content' => 'required|string|max:250',
            'alias' => 'required|string|max:50',
            'is_active' => 'required|string|max:20',
            'category_id' => 'required|int|max:50',
            'side' => 'required|string|max:20',
        ];
    }
}
