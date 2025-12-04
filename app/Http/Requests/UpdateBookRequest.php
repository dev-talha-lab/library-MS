<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $bookId = $this->route('book')?->id ?? $this->route('book');

        return [
            'title' => 'sometimes|required|string|max:255',
            'author' => 'sometimes|nullable|string|max:255',
            'isbn' => [
                'sometimes','required','string','regex:/^[0-9-]+$/',
                Rule::unique('books','isbn')->ignore($bookId),
            ],
            'published_year' => 'sometimes|nullable|digits:4|integer',
            'copies_available' => 'sometimes|required|integer|min:0',
        ];
    }
}
