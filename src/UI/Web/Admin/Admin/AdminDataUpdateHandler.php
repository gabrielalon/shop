<?php

namespace App\UI\Web\Admin\Admin;

use App\Components\Account\Account;
use App\UI\Web\WebHandler;
use Illuminate\Http\RedirectResponse;

class DataUpdateHandler extends WebHandler
{
    /** @var Account */
    private $account;

    /**
     * DataUpdateHandler constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @param string            $adminId
     * @param DataUpdateRequest $request
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function __invoke(string $adminId, DataUpdateRequest $request): RedirectResponse
    {
        $this->account->updateAdmin(
            $adminId,
            $request->input('full_name'),
            $request->input('locale'),
            array_keys($request->input('roles'))
        );

        return redirect()->back()->with([
            'success' => __('form.flash.success'),
            'pane' => 'data-update',
        ]);
    }
}
