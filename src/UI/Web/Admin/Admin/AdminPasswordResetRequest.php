<?php

namespace App\UI\Web\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'password' => 'required|confirmed|min:8',
        ];
    }
}
