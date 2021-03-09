<?php

namespace Database\Factories;

use App\Components\B2B\Infrastructure\Entity\Ticket;
use App\Components\B2B\Infrastructure\Entity\TicketComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCommentFactory extends Factory
{
    /** @var string */
    protected $model = TicketComment::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'ticket_id' => Ticket::factory()->create()->id,
            'content' => $this->faker->text,
        ];
    }
}
