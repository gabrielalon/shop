<?php

namespace App\Components\Account\Application\Command\CreateAdmin;

use App\Components\Account\Application\Command\AdminCommandHandler;
use App\Components\Account\Domain\Admin;
use App\Components\Account\Domain\Persist\AdminRepository;
use App\System\Messaging\Command\Command;
use Illuminate\Contracts\Hashing\Hasher;

final class CreateAdminHandler extends AdminCommandHandler
{
    /** @var Hasher */
    private Hasher $hasher;

    /**
     * CreateAdminHandler constructor.
     *
     * @param Hasher          $hasher
     * @param AdminRepository $repository
     */
    public function __construct(Hasher $hasher, AdminRepository $repository)
    {
        $this->hasher = $hasher;
        parent::__construct($repository);
    }

    /**
     * {@inheritdoc}
     */
    public function run(Command $command): void
    {
        assert($command instanceof CreateAdmin);

        $this->repository->flush(Admin::create(
            $command->id(),
            $command->firstName(),
            $command->lastName(),
            $command->email(),
            $this->hasher->make($command->password())
        ));
    }
}
