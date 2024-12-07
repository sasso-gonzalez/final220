<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'family_code' => 'nullable|string|max:50',
            'emergency_contact' => 'nullable|string|max:50',
            'relation_emergency_contact' => 'nullable|string|max:50',
            'password' => 'nullable|string|confirmed|min:8',
            'status' => 'sometimes|string|in:pending,active,inactive',
        ];
    }
}
