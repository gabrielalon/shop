<?php

namespace App\System\Valuing\Date;

use App\System\Valuing\VO;
use DateTime;
use Exception;
use InvalidArgumentException;

final class Date extends VO
{
    /** @var DateTime */
    private $date;

    /**
     * @param int $date
     *
     * @return Date
     *
     * @throws InvalidArgumentException
     */
    public static function fromDate(int $date): Date
    {
        return new self($date);
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function date(string $format): string
    {
        return $this->date->format($format);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($date): void
    {
        try {
            $this->date = new DateTime($date);
        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
