<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //no authentication required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Validation messages
    */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.min'      => 'Name must be at least 3 characters long',
            'name.max'      => 'Name must not exceed 255 characters',
            'description.max' => 'Description must not exceed 1000 characters',
        ];
    }
}
