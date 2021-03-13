<?php

namespace App\UI\Web\Admin\Admin;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Illuminate\Rules\FullName;
use Illuminate\Foundation\Http\FormRequest;

class DataUpdateRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        $roles = [
            'full_name' => ['required', 'string', new FullName()],
            'locale' => 'string|exists:language,code',
            'roles' => 'array|required',
            'roles.*' => 'array',
        ];

        foreach (RoleEnum::values() as $role) {
            $roles['roles.'.$role->getValue()] = 'nullable|string|uuid|exists:role,id';
        }

        return $roles;
    }
}
