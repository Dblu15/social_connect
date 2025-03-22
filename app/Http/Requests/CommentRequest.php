<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
                'post_id' => 'required|exists:posts,id',
                'user_id' => 'required|exists:users,id',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'post_id' => 'exists:posts,id',
                'user_id' => 'exists:users,id',
                'content' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];
        }
        return [];
    }

    public function messages(): array
    {
        if ($this->isMethod('post')) {
            return [
                'post_id.required' => 'Post is required.',
                'post_id.exists' => 'Post does not exist.',
                'user_id.required' => 'User is required.',
                'user_id.exists' => 'User does not exist.',
                'content.required' => 'Comment is required.',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'post_id.exists' => 'Post does not exist.',
                'user_id.exists' => 'User does not exist.',
                'image.image' => 'Image must be jpeg, png, jpg, gif.',
                'image.max' => 'Image is too large.',
            ];
        }
        return [];
    }
}
