<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                'name' => ['required', 'string', 'min:2'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6'],
                'passwordConfirmation' => ['required', 'same:password'],
                'role' => ['required', Rule::in(['admin', 'user'])],
                'is_verify' => ['required', 'boolean'],
                'bio' => ['nullable', 'string'],
                'avatar' => ['nullable', 'image', 'max:2048'],
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'name' => ['string', 'min:2'],
                'email' => ['email', 'unique:users,email'],
                'role' => [Rule::in(['admin', 'user'])],
                'is_verify' => ['boolean'],
                'bio' => ['string'],
                'avatar' => ['image', 'max:2048'],
            ];
        }
        return [];
    }

    public function messages(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name.required' => 'Name is required.',
                'name.min' => 'Name must be at least 2 characters.',
                'email.required' => 'Email is required.',
                'email.email' => 'Email must be a valid email address.',
                'email.unique' => 'Email must be unique.',
                'password.required' => 'Please enter password.',
                'password.min' => 'Password must be at least 6 characters.',
                'passwordConfirmation.required' => 'Password Confirmation is required.',
                'passwordConfirmation.same' => 'Password Confirmation does not match.',
                'role.required' => 'Role is required.',
                'role.in' => 'Role must be a valid role.',
                'is_verify.required' => 'Is Verify is required.',
                'is_verify.boolean' => 'Is Verify must be a boolean.',
                'avatar.image' => 'Avatar image must be an image.',
                'avatar.max' => 'Avatar max size 2 MB.',
            ];
        }
        if ($this->isMethod('put')) {
            return [
                'name.min' => 'Name must be at least 2 characters.',
                'email.email' => 'Email must be a valid email address.',
                'email.unique' => 'Email must be unique.',
                'role.in' => 'Role must be a valid role.',
                'is_verify.boolean' => 'Is Verify must be a boolean.',
                'avatar.image' => 'Avatar image must be an image.',
                'avatar.max' => 'Avatar max size 2 MB.',
            ];
        }
        return [];
    }
}
