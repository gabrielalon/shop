<?php

namespace App\UI\Web\Account\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminAvatarChangeRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:4048',
        ];
    }
}
