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

        return [
            'address' => $this->faker->ipv4,
            'name' => $domain,
            'ssh_user' => 'servermanager',
            'ssh_key' => 'openssh-' . $domain,
        ];
    }
}
