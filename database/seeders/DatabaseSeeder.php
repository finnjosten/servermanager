<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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
                'password' => bcrypt(vlx_get_env_string('SETTING_DEFAULT_PASSWORD')),
                'datalix_token' => Crypt::encrypt(vlx_get_env_string('SETTING_DEFAULT_DATALIX_TOKEN')),
                'blocked' => false,
                'verified' => true,
                'admin' => true,
            ));
        }

        $this->call(NodeSeeder::class);

    }
}
