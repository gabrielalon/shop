<?php

namespace App\Components\Account\Domain\Valuing;

use App\System\Valuing\VO;
use Illuminate\Support\Arr;

final class Name extends VO
{
    /** @var string */
    private string $firstName;

    /** @var string */
    private string $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return Name
     */
    public static function fromData(string $firstName, string $lastName): Name
    {
        return new static([
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        $this->firstName = Arr::get($value, 'first_name', '');
        $this->lastName = Arr::get($value, 'last_name', '');
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }
}
