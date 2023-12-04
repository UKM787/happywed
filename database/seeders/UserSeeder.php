<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = \Faker\Factory::create();
        $guests = [
            [
                'name' => 'guest',
                'email' => 'guest@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'status'    => 1,
                'slug'   => Str::slug('guest'),
                'password' => Hash::make('123'),
                // 'password' => Hash::make('shashank'),
            ],
           /*  [
                'name' => 'guest1',
                'email' => 'guest1@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest1'),
                'password' => Hash::make('123'),
                // 'password' => Hash::make('shashank'),
            ],
            [
                'name' => 'guest2',
                'email' => 'guest2@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest2'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest3',
                'email' => 'guest3@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest3'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest4',
                'email' => 'guest4@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest4'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest5',
                'email' => 'guest5@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest5'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest6',
                'email' => 'guest6@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest6'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest7',
                'email' => 'guest7@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest7'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest8',
                'email' => 'guest8@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest8'),
                'password' => Hash::make('123'),
            ],
            [
                'name' => 'guest9',
                'email' => 'guest9@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'active'    => 1,
                'slug'   => Str::slug('guest9'),
                'password' => Hash::make('123'),
            ], */

        ];

        foreach ($guests as $key => $value) {
            User::create($value);
        }

        User::all()->map(function ($user) {
            $user->assignRole($user->slug);
        });
    }
}
