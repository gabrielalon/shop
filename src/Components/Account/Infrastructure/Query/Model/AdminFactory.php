<?php

namespace App\Components\Account\Infrastructure\Query\Model;

use App\Components\Account\Application\Query\Model\Admin;
use App\Components\Account\Application\Query\Model\AdminAvatar;
use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use App\System\Spatie\Media\MediaEnum;

class AdminFactory
{
    /** @var MediaEnum */
    private MediaEnum $mediaCollection;

    /**
     * AdminFactory constructor.
     */
    public function __construct()
    {
        $this->mediaCollection = MediaEnum::AVATAR();
    }

    /**
     * @param AdminEntity $entity
     *
     * @return Admin
     */
    public function fromEntity(AdminEntity $entity): Admin
    {
        return new Admin(
            $entity->id,
            $entity->user_id,
            $entity->first_name,
            $entity->last_name,
            $entity->email,
            $this->buildAvatar($entity)
        );
    }

    /**
     * @param AdminEntity $entity
     *
     * @return AdminAvatar
     */
    private function buildAvatar(AdminEntity $entity): AdminAvatar
    {
        if (true === $entity->hasMedia($this->mediaCollection->getValue())) {
            $media = $entity->getFirstMedia($this->mediaCollection->getValue());

            return new AdminAvatar(
                true,
                $media->file_name,
                $media->getUrl($this->mediaCollection->getValue()),
                $media($this->mediaCollection->getValue())
            );
        }

        return new AdminAvatar(false);
    }
}
