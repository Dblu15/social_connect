<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'user_id' => 'required|integer|exists:users,id',
                'post_id' => 'required|integer|exists:posts,id',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'user_id' => 'integer|exists:users,id',
                'post_id' => 'integer|exists:posts,id',
            ];
        }
        return [];
    }

    public function messages(): array
    {
        if ($this->isMethod('post')) {
            return [
                'user_id.required' => 'User ID is required.',
                'user_id.integer' => 'User ID must be an integer.',
                'user_id.exists' => 'User ID does not exist.',
                'post_id.required' => 'Post ID is required.',
                'post_id.integer' => 'Post ID must be an integer.',
                'post_id.exists' => 'Post ID does not exist.',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'user_id.integer' => 'User ID must be an integer.',
                'user_id.exists' => 'User ID does not exist.',
                'post_id.integer' => 'Post ID must be an integer.',
                'post_id.exists' => 'Post ID does not exist.',
            ];
        }
        return [];
    }
}
