<?php

namespace App\System\Eloquent\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuidTrait
{
    public static function bootHasUuidTrait(): void
    {
        static::creating(function ($model) {
            $uuidFieldName = $model->getUuidFieldName();
            if (empty($model->$uuidFieldName)) {
                $model->$uuidFieldName = static::generateUuid();
            }
        });
    }

    /**
     * @return string
     */
    public static function generateUuid(): string
    {
        return Str::uuid()->toString();
    }

    /**
     * @param string $uuid
     *
     * @return Model|null
     */
    public static function findByUuid(string $uuid): ?Model
    {
        return static::query()->where((new self())->getUuidFieldName(), '=', $uuid)->first();
    }

    /**
     * @param Builder $query
     * @param string  $uuid
     *
     * @return Builder
     */
    public function scopeByUuid(Builder $query, string $uuid): Builder
    {
        return $query->where($this->getUuidFieldName(), $uuid);
    }

    /**
     * @return string
     */
    public function getUuidFieldName(): string
    {
        if (!empty($this->uuidFieldName)) {
            return $this->uuidFieldName;
        }

        return $this->getKeyName();
    }
}
