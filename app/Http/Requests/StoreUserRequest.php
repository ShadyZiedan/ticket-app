<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userModel = $this->route('user');
        return $this->user()->can('store', $userModel);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200',
            'email' => ['required' ,'unique:users', 'email:rfc,dns'],
            'password' => [
                Password::required(),
                Password::min(8)->letters()->numbers(),
            ],
            'role_id' => ['nullable', 'exists:roles'],
        ];
    }
}
