<?php

namespace Database\Seeders;


use App\Models\Host\Host;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class HostSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $hosts = [
            [
                'name' => 'Organizer',
                'email' => 'organizer@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'location_id' => '3',
                'status' => 1,
                'role' => ['organizer'],
                'slug'   => Str::slug('organizer'),
                'password' => bcrypt('123'),
                //'roles_user' => $host
            ],
            [
                'name' => 'Host',
                'email' => 'host@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'location_id' => '3',
                'status' => 1,
                'role' => ['host'],
                'slug'   => Str::slug('host'),
                'password' => bcrypt('123'),
                //'roles_user' => $host
            ],
            [
                'name' => 'bride',
                'email' => 'bride@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'location_id' => '3',
                'status' => 1,
                'slug'   => Str::slug('bride'),
                'password' => bcrypt('123'),
                'role' => ['bride']
            ],
            [
                'name' => 'groom',
                'email' => 'groom@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'location_id' => '3',
                'status' => 1,
                'slug'   => Str::slug('groom'),
                'password' => bcrypt('123'),
                'role' => ['groom']
            ],
            // [
            //     'name' => 'member',
            //     'email' => 'member@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => '3',
            //     'status' => 1,
            //     'slug'   => Str::slug('member'),
            //     'password' => bcrypt('123'),
            //     'roles_user' => "[member]"
            // ],
            // [
            //     'name' => 'host1',
            //     'email' => 'host1@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'chandigarh',
            //     'status' => 1,
            //     'slug'   => Str::slug('host1'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'host2',
            //     'email' => 'host2@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'chandigarh',
            //     'status' => 1,
            //     'slug'   => Str::slug('host2'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'host3',
            //     'email' => 'host3@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'chandigarh',
            //     'status' => 1,
            //     'slug'   => Str::slug('host3'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'host4',
            //     'email' => 'host4@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'chandigarh',
            //     'status' => 1,
            //     'slug'   => Str::slug('host4'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'host5',
            //     'email' => 'host5@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'chandigarh',
            //     'status' => 1,
            //     'slug'   => Str::slug('host5'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'Weding Agency One',
            //     'email' => 'emanager1@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id'=> 'Bangalore',
            //     'status' => 1,
            //     'slug'   => Str::slug('weding-agency-one'),
            //     'password' => bcrypt('123'),
            // ],
            // [
            //     'name' => 'Weding Agency Two',
            //     'email' => 'emanager2@gmail.com',
            //     'email_verified_at' => now(),
            //     'mobile' =>  $faker->unique()->phoneNumber(),
            //     'location_id' => 'Bangalore',
            //     'status' => 1,
            //     'slug'   => Str::slug('weding-agency-two'),
            //     'password' => bcrypt('123'),
            // ],
        ];

        foreach ($hosts as $key => $value) {
            $host = Host::create($value);
        }

        // Host::all()->each(function($host){
        //     $host->assignRole($host->slug);
        // });

    }
}
