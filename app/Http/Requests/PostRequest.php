<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'user_id' => ['integer', 'exists:users,id'],
            'privacy' => [Rule::in(['public', 'private', 'friends'])],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['nullable', 'boolean'],
            'content' => ['string'],
        ];
    }

    public function messages(): array{
        return [
            'user_id.integer' => 'User must be an integer.',
            'user_id.exists' => 'User not exists.',
            'privacy.string' => 'Privacy must be string.',
            'privacy.in' => 'Privacy must be in rule.',
            'image.image' => 'Image must be an image.',
            'image.max' => 'Image must be less than 2MB.',
            'status.boolean' => 'Status must be boolean.',
            'content.string' => 'Content must be string.',
        ];
    }
}
