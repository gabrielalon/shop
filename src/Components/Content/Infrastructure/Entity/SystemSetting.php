<?php

namespace App\Components\Content\Infrastructure\Entity;

use App\Components\Content\Domain\Enum\SystemSettingType;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @property int    $id
 * @property string $key
 * @property string $data_type
 * @property string $data
 */
final class SystemSetting extends Eloquent
{
    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'system_setting';

    /** @var array */
    protected $guarded = [];

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        switch ($this->data_type) {
            case SystemSettingType::BOOLEAN()->getValue():
                return filter_var($this->data, FILTER_VALIDATE_BOOLEAN);
            case SystemSettingType::INTEGER()->getValue():
                return filter_var($this->data, FILTER_VALIDATE_INT);
            case SystemSettingType::STRING()->getValue():
            default:
                return $this->data;
        }
    }
}
