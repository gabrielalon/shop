<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\UI\Web\WebHandler;
use Illuminate\Http\RedirectResponse;

class AdminRemoveHandler extends WebHandler
{
    /** @var Account */
    private $account;

    /**
     * RemoveHandler constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @param string $adminId
     *
     * @return RedirectResponse
     *
     * @throws \Exception
     */
    public function __invoke(string $adminId): RedirectResponse
    {
        $this->account->remove($adminId);

        return redirect()->back()->with([
            'success' => __('form.flash.success'),
            'pane' => 'data-update',
        ]);
    }
}
