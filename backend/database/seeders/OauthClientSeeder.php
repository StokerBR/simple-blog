<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('oauth_clients')->insert([
            [
                'name' => 'Laravel Personal Access Client',
                'secret' => 'XZcYWLYPVb60tkBXaZ2XkBUyCJZMZkSzV7MRXuNd',
                'redirect' => 'http://localhost',
                'personal_access_client' => true,
                'password_client' => false,
                'revoked' => false,
            ],
            [
                'name' => 'Laravel Password Grant Client',
                'secret' => 'atfqA5GPpI8HofYcBpAf0LGC9LDKkL1MQ0uLwWtn',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => false,
                'password_client' => true,
                'revoked' => false,
            ]
        ]);

    }
}
