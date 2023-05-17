<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        User::updateOrCreate(
            ['name' => 'Soporte'],
            [
                'email' => 'soporte@soporte.com',
                'email_verified_at' => now(),
                'password' => bcrypt('soporte1'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
