<?php

namespace App\Components\Account\Application\Validator;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class UserValidatorFactory
{
    /** @var Factory */
    private $factory;

    /**
     * ContractorValidatorFactory constructor.
     *
     * @param Factory $factory
     */
    private function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Factory $factory
     *
     * @return UserValidatorFactory
     */
    public static function initialize(Factory $factory): UserValidatorFactory
    {
        return new UserValidatorFactory($factory);
    }

    /**
     * @param string $userId
     *
     * @return Validator
     */
    public function exists(string $userId): Validator
    {
        return $this->factory->make(['user_id' => $userId], [
            'user_id' => 'required|exists:user,id|uuid',
        ]);
    }
}
