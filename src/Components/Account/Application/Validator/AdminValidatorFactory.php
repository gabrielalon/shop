<?php

namespace App\Components\Account\Application\Validator;

use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

class AdminValidatorFactory
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
     * @return AdminValidatorFactory
     */
    public static function initialize(Factory $factory): AdminValidatorFactory
    {
        return new AdminValidatorFactory($factory);
    }

    /**
     * @param string $adminId
     *
     * @return Validator
     */
    public function exists(string $adminId): Validator
    {
        return $this->factory->make(['admin_id' => $adminId], [
            'admin_id' => 'required|exists:admin,id|uuid',
        ]);
    }
}
