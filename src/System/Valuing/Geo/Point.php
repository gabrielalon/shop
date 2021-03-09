<?php

namespace App\System\Valuing\Geo;

use App\System\Valuing as VO;
use InvalidArgumentException;
use function sprintf;
use Webmozart\Assert\Assert as Assertion;

final class Point extends VO\VO
{
    /** @var VO\Number\Decimal */
    private $lat;

    /** @var VO\Number\Decimal */
    private $lng;

    /**
     * @param float $lat
     * @param float $lng
     *
     * @return Point
     *
     * @throws InvalidArgumentException
     */
    public static function fromCoordinates(float $lat, float $lng): Point
    {
        return new self([
            'lat' => $lat,
            'lng' => $lng,
        ]);
    }

    /**
     * @return Point
     */
    public static function empty(): Point
    {
        return self::fromCoordinates(0.0, 0.0);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return 0.0 === $this->latitude() && 0.0 === $this->longitude();
    }

    /**
     * @return float
     */
    public function latitude(): float
    {
        return (float) $this->lat->raw();
    }

    /**
     * @return float
     */
    public function longitude(): float
    {
        return (float) $this->lng->raw();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf(
            '%s %s',
            $this->lat->toString(),
            $this->lng->toString()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($coordinates): void
    {
        Assertion::greaterThan($coordinates['lat'], -90.0, 'Expected latitude coordinate greater than %2$s. Got: %s');
        Assertion::lessThan($coordinates['lat'], 90.0, 'Expected latitude coordinate less than %2$s. Got: %s');
        Assertion::greaterThan($coordinates['lng'], -180.0, 'Expected longitude coordinate greater than %2$s. Got: %s');
        Assertion::lessThan($coordinates['lng'], 180.0, 'Expected longitude coordinate less than %2$s. Got: %s');
    }

    /**
     * @param array $coordinates
     */
    protected function setValue($coordinates): void
    {
        $this->lat = VO\Number\Decimal::fromFloat($coordinates['lat']);
        $this->lng = VO\Number\Decimal::fromFloat($coordinates['lng']);
        parent::setValue($coordinates);
    }
}
