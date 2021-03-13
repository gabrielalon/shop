<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Infrastructure\Entity\Admin as AdminEntity;
use App\System\Spatie\Media\MediaEnum;
use App\System\Spatie\Media\MediaService;
use App\UI\Web\WebHandler;
use Illuminate\Http\RedirectResponse;

class AdminAvatarChangeHandler extends WebHandler
{
    /** @var AdminEntity */
    private AdminEntity $db;

    /** @var MediaService */
    private MediaService $mediaService;

    /**
     * AvatarChangeHandler constructor.
     *
     * @param AdminEntity  $db
     * @param MediaService $mediaService
     */
    public function __construct(AdminEntity $db, MediaService $mediaService)
    {
        $this->db = $db;
        $this->mediaService = $mediaService;
    }

    /**
     * @param string                   $adminId
     * @param AdminAvatarChangeRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(string $adminId, AdminAvatarChangeRequest $request): RedirectResponse
    {
        $this->mediaService->setMedia(
            $this->db->newQuery()->find($adminId),
            $request->file(MediaEnum::AVATAR()),
            MediaEnum::AVATAR()
        );

        return redirect()->back()->with([
            'success' => __('form.flash.success'),
            'pane' => 'data-update',
        ]);
    }
}
