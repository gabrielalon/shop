<?php

namespace App\System\Messaging\Integration\Service;

class CallbackSerializer
{
    /** callable */
    private $serializeCallback = 'serialize';

    /** callable */
    private $unserializeCallback = 'unserialize';

    /**
     * @param array|object $data
     *
     * @return string
     */
    public function serialize($data)
    {
        return \call_user_func($this->serializeCallback, $data);
    }

    /**
     * @param string $serialized
     *
     * @return array|object
     */
    public function unserialize($serialized)
    {
        return \call_user_func($this->unserializeCallback, $serialized);
    }
}
