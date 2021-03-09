<?php

namespace App\System\Valuing\Date;

use App\System\Valuing\VO;
use Carbon\Carbon;

final class Period extends VO
{
    /** @var Carbon */
    private $from;

    /** @var Carbon */
    private $until;

    /**
     * @param array $from
     * @param array $until
     *
     * @return Period
     */
    public static function fromPeriod(array $from, array $until): Period
    {
        return new self([
            'from' => $from,
            'until' => $until,
        ]);
    }

    /**
     * @return Carbon
     */
    public function from(): Carbon
    {
        return $this->from;
    }

    /**
     * @return Carbon
     */
    public function until(): Carbon
    {
        return $this->until;
    }

    /**
     * @return int
     */
    public function inDays(): int
    {
        $dropOff = $this->until->copy();
        $pickup = $this->from->copy();

        $dropOff->startOfDay();
        $pickup->startOfDay();

        return $dropOff->diffInDays($pickup);
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        $this->from = $this->createDateFromData($value['from']);
        $this->until = $this->createDateFromData($value['until']);
    }

    /**
     * @param array $data
     *
     * @return Carbon
     */
    private function createDateFromData(array $data): Carbon
    {
        return Carbon::create(
            $data['year'],
            $data['month'],
            $data['day'],
            $data['hour'],
            $data['minute'],
            $data['second'],
            $data['timezone']
        );
    }
}
