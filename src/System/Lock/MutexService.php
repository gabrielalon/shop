<?php

namespace App\System\Lock;

interface MutexService
{
    /**
     * @param string $name
     *
     * @return MutexService
     */
    public function forName(string $name): MutexService;

    public function releaseBadLock(): void;

    /**
     * @return bool
     */
    public function releaseLock(): bool;

    /**
     * @param bool $shouldBlock
     * @param int  $timeout
     *
     * @return bool
     *
     * @throws Exception\MutexFailedException
     */
    public function acquireLock($shouldBlock = true, $timeout = 60): bool;
}
