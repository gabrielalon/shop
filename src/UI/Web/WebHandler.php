<?php

namespace App\UI\Web;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class WebHandler extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * {@inheritdoc}
     */
    public function callAction($method, $parameters)
    {
        if ('__invoke' === $method) {
            return call_user_func_array([$this, $method], $parameters);
        }

        throw new \BadMethodCallException('Only __invoke method can be called on handler.');
    }
}
