<?php

namespace App\System\Illuminate\Rules;

use Illuminate\Support\Facades\Storage;

class FileExists extends Rule
{
    /**
     * The rule has two parameters:
     * 1. The disk defined in your config file.
     * 2. The directory to search within.
     *
     * {@inheritdoc}
     */
    public function passes($attribute, $value): bool
    {
        $path = rtrim($this->parameters[1] ?? '', '/');
        $file = ltrim($value, '/');

        return Storage::disk($this->parameters[0])->exists("$path/$file");
    }

    /**
     * {@inheritdoc}
     */
    public function message(): string
    {
        return $this->getLocalizedErrorMessage(
            'file_exists',
            'The file specified for :attribute does not exist'
        );
    }
}
