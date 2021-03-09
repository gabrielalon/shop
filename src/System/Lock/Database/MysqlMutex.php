<?php

namespace App\System\Lock\Database;

use App\System\Lock\Exception\MutexFailedException;
use App\System\Lock\MutexService;
use Illuminate\Support\Facades\DB;

final class MysqlMutex implements MutexService
{
    /** @var string */
    private $name;

    /** @var bool */
    private $hasLock = false;

    /**
     * {@inheritdoc}
     */
    public function forName(string $name): MutexService
    {
        $this->name = $name;

        return $this;
    }

    public function releaseBadLock(): void
    {
        $this->hasLock = true;
        $this->releaseLock();
    }

    /**
     * {@inheritdoc}
     */
    public function acquireLock($shouldBlock = true, $timeout = 60): bool
    {
        if (false === $shouldBlock) {
            $timeout = 0;
        }

        if (true === $this->hasLock) {
            return true;
        }

        $result = DB::selectOne('SELECT IS_FREE_LOCK(:name) AS `result`', ['name' => $this->name]);

        if (1 === $result->result) {
            $result = DB::selectOne('SELECT GET_LOCK(:name, :timeout) AS `result`', [
                'name' => $this->name,
                'timeout' => $timeout,
            ]);

            if (1 === $result->result) {
                $this->hasLock = true;

                return true;
            }

            $this->hasLock = false;
            throw new MutexFailedException($this->name);
        }

        $this->hasLock = false;
        throw new MutexFailedException($this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function releaseLock(): bool
    {
        if (true === $this->hasLock) {
            DB::statement('SELECT RELEASE_LOCK(:name) AS `result`', ['name' => $this->name]);
            $this->hasLock = false;
        }

        return true;
    }
}
