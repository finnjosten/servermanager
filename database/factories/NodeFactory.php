<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Node>
 */
class NodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $domain = $this->faker->domainWord();

        return [];

        /* return [
            'ipv4' => null,
            'fqdn' => 'oliver.vacso.cloud', // Hardcoded for testing
            'name' => 'Oliver',
            'endpoint' => 'https://oliver.vacso.cloud/api',
            'key' => 'test', // Change to a hardcoded value
        ];

        return [
            'address' => $this->faker->ipv4,
            'name' => $domain,
            'endpoint' => 'https://' . $domain . '/api',
            'key' => "test",
        ]; */
    }
}
