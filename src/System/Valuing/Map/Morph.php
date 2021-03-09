<?php

namespace App\System\Valuing\Map;

use App\System\Valuing as VO;

abstract class Morph extends VO\VO
{
    /** @var VO\Char\Text */
    private $type;

    /** @var string|int */
    private $id;

    /**
     * @param string     $type
     * @param string|int $id
     *
     * @return static
     */
    public static function fromData(string $type, $id): self
    {
        return new static([
            'type' => $type,
            'id' => $id,
        ]);
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type->toString();
    }

    /**
     * @return string|int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    protected function guard($value): void
    {
        $this->type = VO\Char\Text::fromString($value['type']);
        $this->id = $value['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return json_encode($this->value);
    }
}
