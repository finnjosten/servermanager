<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Ramsey\Uuid\Uuid as UUID;
use App\Models\Node;

class NodeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {

        /*\App\Models\Node::factory()->create([
            'address' => 'oliver.vacso.cloud',
            'name' => 'Oliver',
            'endpoint' => 'https://oliver.vacso.cloud/api',
            'key' => env('KEY_LIAM'),
        ]);
        \App\Models\Node::factory(1)->create();

        dd(\App\Models\Node::all()); */

        Node::create([
            'ipv4' => "1.1.1.1",
            'fqdn' => 'noah.vacso.cloud',
            'name' => 'Noah',
            'endpoint' => 'https://sm-api.noah.vacso.cloud/api',
            'key' => Crypt::encrypt(env('KEY_NOAH')),
            'user_id' => 1,
        ]);

        Node::create([
            'ipv4' => "1.1.1.2",
            'fqdn' => 'oliver.vacso.cloud',
            'name' => 'Oliver',
            'endpoint' => 'https://sm-api.oliver.vacso.cloud/api',
            'key' => Crypt::encrypt(env('KEY_OLIVER')),
            'user_id' => 1,
        ]);

    }
}
