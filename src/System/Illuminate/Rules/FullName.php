<?php

namespace App\System\Illuminate\Rules;

class FullName extends Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return 1 === preg_match('/^[a-zA-Z]+(?:\s[a-zA-Z]+)+$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->getLocalizedErrorMessage(
            'full_name',
            'Provided :attribute is invalid'
        );
    }
}
