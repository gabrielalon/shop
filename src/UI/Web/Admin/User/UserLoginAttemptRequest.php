<?php

namespace App\UI\Web\Account\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginAttemptRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|exists:user,email',
            'password' => 'required|string',
        ];
    }
}
