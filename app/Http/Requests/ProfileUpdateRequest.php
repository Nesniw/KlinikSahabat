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
            'fullname' => ['required','string', 'max:255'],
            'jeniskelamin' => ['required', 'string'],
            'tanggallahir' => ['required', 'date'],
            'alamat' => ['required', 'string', 'max:255'],
            'email' => ['required','email', 'max:255'],
            'nomortelepon' => ['required', 'string', 'max:14'],
        ];
    }
}
