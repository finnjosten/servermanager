<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid as UUID;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {

        if(env('SETTING_DEFAULT_ACCOUNT')) {
            \App\Models\User::factory()->create(array(
                'uuid' => UUID::uuid4()->toString(),
                'name' => vlx_get_env_string('SETTING_DEFAULT_USERNAME'),
                'email' => vlx_get_env_string('SETTING_DEFAULT_EMAIL'),
                'password' => Hash::make(vlx_get_env_string('SETTING_DEFAULT_PASSWORD')),
                'blocked' => false,
                'verified' => true,
                'admin' => true,
            ));
        }

        $this->call(NodeSeeder::class);

    }
}
