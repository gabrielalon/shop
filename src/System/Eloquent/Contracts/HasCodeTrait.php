<?php

namespace App\System\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasCodeTrait
{
    /**
     * @param string $code
     *
     * @return Model|null
     */
    public static function findByCode(string $code): ?Model
    {
        return static::query()->where((new self())->getCodeFieldName(), '=', $code)->first();
    }

    /**
     * @param Builder $query
     * @param string  $code
     *
     * @return Builder
     */
    public function scopeByCode(Builder $query, string $code): Builder
    {
        return $query->where($this->getCodeFieldName(), $code);
    }

    /**
     * @return string
     */
    public function getCodeFieldName(): string
    {
        if (!empty($this->codeFieldName)) {
            return $this->codeFieldName;
        }

        return $this->getKeyName();
    }
}
