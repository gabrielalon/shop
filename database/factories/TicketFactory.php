<?php

namespace Database\Factories;

use App\Components\B2B\Domain\Enum\TicketStatus;
use App\Components\B2B\Domain\Enum\TicketType;
use App\Components\B2B\Infrastructure\Entity\Project;
use App\Components\B2B\Infrastructure\Entity\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /** @var string */
    protected $model = Ticket::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'number' => $this->faker->unique()->numberBetween(10 ^ 5, 10 ^ 6),
            'project_id' => Project::factory()->create()->id,
            'name' => $this->faker->name,
            'content' => $this->faker->text,
            'status' => TicketStatus::NEW()->getValue(),
            'type' => TicketType::FEATURE()->getValue(),
        ];
    }
}
