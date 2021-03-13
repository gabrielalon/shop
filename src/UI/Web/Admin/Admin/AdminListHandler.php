<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class AdminListHandler extends WebHandler
{
    /** @var Account */
    private Account $account;

    /**
     * ListHandler constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        $collection = $this->account
            ->askAdmin()
            ->findAdminCollection();

        return view('admin.account.list')->with([
            'admin_collection' => $collection,
        ]);
    }
}
