<?php

namespace Database\Factories;

use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Attribute;
use App\Models\Project;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeValue>
 */
class AttributeValueFactory extends Factory
{
    protected $model = AttributeValue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attribute = Attribute::inRandomOrder()->first();

        $value = match ($attribute->type) {
            'date' => $this->faker->date(),
            'number' => $this->faker->randomNumber(),
            'select' => $this->faker->randomElement(['High', 'Medium', 'Low']),
            default => $this->faker->word(),
        };

        return [
            'attribute_id' => Attribute::factory(),
            'entity_id' => $this->faker->numberBetween(1, 5),
            'entity_type' => 'App\Models\Project',
            'value' => $value
        ];
    }
}
