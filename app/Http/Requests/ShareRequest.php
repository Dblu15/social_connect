<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user field is required.',
            'user_id.exists' => 'The user does not exist.',
            'post_id.required' => 'The post field is required.',
            'post_id.exists' => 'The post does not exist.',
        ];
    }
}
