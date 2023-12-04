<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Vendor\Vendor;
use Illuminate\Database\Seeder;
use App\Models\Admin\VendorMaster;
use Illuminate\Support\Facades\Hash;

class VendorMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'name', 'description','status', 'parent_id', 'priority', 'icon', 'slug'
        $faker = \Faker\Factory::create();

        $vendors = [
            [
                'name' => 'Vendor',
                'email' => 'vendor@gmail.com',
                'email_verified_at' => now(),
                'mobile' =>  $faker->unique()->phoneNumber(),
                'status' => 1,
                'location_id' => 1,
                'slug'   => Str::slug('vendor'),
                'password' => Hash::make('123')
                // 'password' => bcrypt('123'),
            ],

        ];

        foreach ($vendors as $key => $value) {
            $vendor = Vendor::create($value);
        }

        Vendor::all()->each(function ($vendor) {
            $vendor->assignRole($vendor->slug);
        });

        $vendors =  [
            ['name' => 'Wedding Planners', 'description' => 'Planning of Marriage Activites and Tasks', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'wedding-planners', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'icon' => 'Wedding-Planners.svg', 'imageOne' => "Wedding-Planners.png"],

            ['name' => 'Wedding Venues', 'description' => 'Wedding Venues',  'status' => true,  'priority' => 0, 'slug' => 'wedding-venues', 'relation' => 'venues', 'path' => 'venues',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'icon' => "Venues.svg", 'imageOne' => "Venues.png",],

            ['name' => 'Accommodation', 'description' => 'Wedding Guests Acomodation Providers',  'status' => true,  'priority' => 0, 'slug' => 'accommodation', 'relation' => 'accommodations', 'path' => 'accommodation',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => 'Accommodation.png', 'icon' => 'Accommodation.svg'],

            ['name' => 'Invitation Cards', 'description' => 'Wedding Card Designs',  'status' => true,  'priority' => 0, 'slug' => 'invitation-cards', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Invitation-Cards.png", "icon" => "Invitation-Cards.svg"],

            [
                'name' => 'Catering', 'description' => 'Caterers for Marriages', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'catering',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Catering.png", 'icon' => "Catering.svg"
            ],
            [
                'name' => 'Entertainment', 'description' => 'Wedding Entertainment Artists', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'entertainment',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Entertainment.png", 'icon' => "Entertainment.svg"
            ],

            [
                'name' => 'Flower Decorators', 'description' => 'Wedding Flow Decorators', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'flower-decorators',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Flower-Decorators.png", 'icon' => "Flower-Decorators.svg"
            ],
            [
                'name' => 'Health and Beauty', 'description' => 'Health and Beauty Centers for Marraiges', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'health-and-beauty',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Health-and-Beauty.png", 'icon' => "Health-and-Beauty.svg"
            ],
            [
                'name' => 'Jewellery Stores', 'description' => 'Jewellery Stores for Marriages', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'jewellery-stores',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Jewellery-Stores.png", "icon" => "Jewellery-Stores.svg"
            ],
            [
                'name' => 'Transportation', 'description' => 'Transporters for Marriages for Vans, Buss and Luxury Vehicles', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'transportation',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Transportation.png", "icon" => "Transportation.svg"
            ],

            ['name' => 'Wedding Stationery', 'description' => 'Wedding Stationery',  'status' => true,  'priority' => 0, 'icon' => 'fas fa-tshirt',  'slug' => 'wedding-stationery', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Wedding-Stationery.png", "icon" => "Wedding-Stationery.svg"],

            ['name' => 'Favors & Gifts', 'description' => 'Wedding Favors and Gifts Description',  'status' => true,  'priority' => 0, 'slug' => 'favors-and-gifts', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Favors-and-Gift.png", 'icon' => "Favors-and-Gift.svg"],

            ['name' => 'Groom Styles and Wears', 'description' => 'Wedding Groom Styles and Wear Description',  'status' => true,  'priority' => 0, 'slug' => 'groom-styles-and-wears', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Groom-Styles-and-Wears.png", "icon" => "Groom-Styles-and-Wears.svg"],

            ['name' => 'Bridal Styles and Wears', 'description' => 'Wedding Bride Styles and Wear Description',  'status' => true,  'priority' => 0, 'slug' => 'bridal-styles-and-wears', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bridal-Styles-and-Wears.png", 'icon' => "Bridal-Styles-and-Wears.svg"],

            ['name' => 'Wedding Decors', 'description' => 'Wedding Decors Description',  'status' => true,  'priority' => 0, 'slug' => 'wedding-decors', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Wedding-Decors.png", "icon" => "Wedding-Decors.svg"],

            ['name' => 'Bartenders', 'description' => 'Wedding Bartenders Description',  'status' => true,  'priority' => 0, 'slug' => 'bartenders', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bartenders.png", 'icon' => 'Bartenders.svg'],

            ['name' => 'Clothing Rentals', 'description' => 'Wedding Clothing Rentals Description',  'status' => true,  'priority' => 0, 'slug' => 'clothing-rentals', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Clothing-Rentals.png", "icon" => "Clothing-Rentals.svg"],

            ['name' => 'Cakes', 'description' => 'Wedding Cakes Description',  'status' => true,  'priority' => 0, 'slug' => 'cakes', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Cakes.png", 'icon' => "Cakes.svg"],

            ['name' => 'Choreographers', 'description' => 'Wedding Choreographers Description',  'status' => true,  'priority' => 0, 'slug' => 'choreographers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Choreographers.png", "icon" => "Choreographers.svg"],

            ['name' => 'Photographers', 'description' => 'Wedding Photographers',  'status' => true,  'priority' => 0, 'slug' => 'photographers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Photographers.png", "icon" => "Photographers.svg"],

            ['name' => 'Prewed Photographers', 'description' => 'Wedding Prewed Photographers',  'status' => true,  'priority' => 0, 'slug' => 'prewed-photographers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Prewed-Photographers.png", "icon" => "Prewed-Photographers.svg"],

            ['name' => 'Prewed Videographers', 'description' => 'Wedding Prewed Video Graphers',  'status' => true,  'priority' => 0, 'slug' => 'prewed-videographers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Prewed-Videographers.png", "icon" => "Prewed-Videographers.svg"],

            ['name' => 'VideoGraphers', 'description' => 'Wedding Video Graphers',  'status' => true,  'priority' => 0, 'slug' => 'videographers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "VideoGraphers.png", 'icon' => "VideoGraphers.svg"],

            ['name' => 'Groom Makeup Artists', 'description' => 'Wedding Makeup Artists Description',  'status' => true,  'priority' => 0, 'slug' => 'groom-makeup-artists', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Groom-Makeup-Artists.png", 'icon' => "Groom-Makeup-Artists.svg"],

            ['name' => 'Bridal Makeup Artists', 'description' => 'Wedding Bridal Makeup Artists Description',  'status' => true,  'priority' => 0, 'slug' => 'bridal-makeup-artists', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bridal-Makeup-Artists.png", 'icon' => "Bridal-Makeup-Artists.svg"],

            ['name' => 'Family Makeup Artists', 'description' => 'Wedding Family Makeup Artists Description',  'status' => true,  'priority' => 0, 'slug' => 'family-makeup-artists', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Family-Makeup-Artists.png", 'icon' => "Family-Makeup-Artists.svg"],

            ['name' => 'Wedding Stylists and  Designers', 'description' => 'Wedding Stylists and Designer Description',  'status' => true,  'priority' => 0, 'slug' => 'wedding-stylists-and-designers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Wedding-Stylists-and -Designers.png", "icon" => "Wedding-Stylists-and -Designers.svg"],

            ['name' => 'Bridal Mehendi Artists', 'description' => 'Wedding Bridal Mehendi Artists Description',  'status' => true,  'priority' => 0, 'slug' => 'bridal-mehendi-artists', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bridal-Mehendi-Artists.png", 'icon' => "Bridal-Mehendi-Artists.svg"],

            ['name' => 'Home Catering', 'description' => 'Home Catering',  'status' => true,  'priority' => 0, 'slug' => 'home-catering', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Home-Catering.png", 'icon' => "Home-Catering.svg"],

            ['name' => 'Chaat & Food Stalls', 'description' => 'Chaat and Food Stalls for Marriages',  'status' => true,  'priority' => 0, 'slug' => 'chaat-and-food-stalls', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Chaat-and-Food-Stalls.png", "icon" => "Chaat-and-Food-Stalls.svg"],

            ['name' => 'Bandbaja', 'description' => 'Bandbaja wala for Weddings',  'status' => true,  'priority' => 0, 'slug' => 'bandbaja', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bandbaja.png", 'icon' => 'Bandbaja.svg'],

            ['name' => 'Car Rental Service', 'description' => 'Wedding Car Retnal Service',  'status' => true,  'priority' => 0, 'slug' => 'car-rental-service', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Car-Rental-Service.png", 'icon' => "Car-Rental-Service.svg"],

            ['name' => 'Bridal Jewellery', 'description' => 'Wedding Bridal Jewellery',  'status' => true,  'priority' => 0, 'slug' => 'bridal-jewellery', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bridal-Jewellery.png", 'icon' => "Bridal-Jewellery.svg"],

            ['name' => 'Bridal Jewellery On Rent', 'description' => 'Wedding Bridal Jewellery on Rent',  'status' => true,  'priority' => 0, 'slug' => 'bridal-jewellery-on-rent', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Bridal-Jewellery-On-Rent.png", 'icon' => "Bridal-Jewellery-On-Rent.svg"],

            ['name' => 'Wedding Priests', 'description' => 'Wedding Pandits and Priests',  'status' => true,  'priority' => 0, 'slug' => 'wedding-priests', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Wedding-Priests.png", "icon" => "Wedding-Priests.svg"],

            ['name' => 'Lighting designers', 'description' => 'Wedding Lighting Designers',  'status' => true,  'priority' => 0, 'slug' => 'lighting-designers', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Lighting-designers.png", "icon" => "Lighting-designers.svg"],

            ['name' => 'Anchors', 'description' => 'Wedding Anchors',  'status' => true,  'priority' => 0, 'slug' => 'anchors', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Anchors.png", 'icon' => 'Anchors.svg'],

            ['name' => 'Ghoriwala , Baggi & Palki wale', 'description' => 'Goriwala, Baggi & Palki Wale',  'status' => true,  'priority' => 0, 'slug' => 'ghoriwala-baggi-and-palkiwale', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Ghoriwala.png", 'icon' => "Ghoriwala.svg"],

            ['name' => 'DJ/ Musicians/ Entertainment', 'description' => 'DJ, Musicians and Entertainment Artist Groups',  'status' => true,  'priority' => 0, 'slug' => 'dj-musicians-entertainment', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "DJ-Musicians-Entertainment.png", "icon" => "DJ-Musicians-Entertainment.svg"],

            ['name' => 'Honeymoon Planners', 'description' => 'Honeymoon Planners',  'status' => true,  'priority' => 0, 'slug' => 'honeymoon-planners', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Honeymoon-Planners.png", 'icon' => "Honeymoon-Planners.svg"],

            ['name' => 'Honeymoon Packages', 'description' => 'Honeymonn Packages',  'status' => true,  'priority' => 0, 'slug' => 'honeymoon-packages', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Honeymoon-Packages.png", "icon" => "Honeymoon-Packages.svg"],

            ['name' => 'Security Services', 'description' => 'Security Service Providers for Marraiges',  'status' => true,  'priority' => 0, 'slug' => 'security-services', 'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'admin_id' => 1, 'parent_id' => null, 'imageOne' => "Security-Services.png", "icon" => "Security-Services.svg"],

            [
                'name' => 'Miscellenous', 'description' => 'Planning of Marriage Activites and Tasks', 'status' => 0, 'parent_id' => null, 'admin_id' => 1, 'priority' => 0, 'slug' => 'miscellenous',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30', 'imageOne' => "Miscellenous.png", "icon" => "Miscellenous.svg"
            ],
            // Wedding Venues
            [
                'name' => 'Resorts', 'description' => 'Resorts Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'resorts-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Destinations', 'description' => 'Destination Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5414.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'destination-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Beach & Island', 'description' => 'Beach & Island Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5416.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'beach-island-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Hotels', 'description' => 'Hotel Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5417.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'hotel-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Lawns & Farmhouses', 'description' => 'Lawns and Farmhouse Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'lawns-farmhouse-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => ' Palaces & Forts', 'description' => ' Palace & Forts Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'palace-forts-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Amusement Parks', 'description' => 'Amusement Parks Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'amusements-parks-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Cruise & Boats', 'description' => 'Cruise Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'cruise-boats-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Place of Worships', 'description' => 'Place of Worship Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'place-of-worhip-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Garden Weddings', 'description' => 'Garden Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'garden-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Banquent Halls', 'description' => 'Banquent Halls Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'banquent-hall-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Community Centers', 'description' => 'Community Center Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'community-center-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Kalyan Mandapam', 'description' => 'Kalyan Mandapam Weddings', 'status' => 0, 'parent_id' => 2, 'imageOne' => '/assets/venues/Frame5413.png', 'admin_id' => 1, 'priority' => 0, 'slug' => 'Kalyan-Mandapam-weddings',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            // wedding accommodations
            [
                'name' => 'Guest house', 'description' => 'Geust Houses for Guest Accommodations', 'status' => 0, 'parent_id' => 3, 'admin_id' => 1, 'priority' => 0, 'slug' => 'Guest-house',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Villas', 'description' => 'Villa for Guest Accommodations', 'status' => 0, 'parent_id' => 3, 'admin_id' => 1, 'priority' => 0, 'slug' => 'Villas',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ],
            [
                'name' => 'Hotels', 'description' => 'Hotels for Guest Accommodations', 'status' => 0, 'parent_id' => 3, 'admin_id' => 1, 'priority' => 0, 'slug' => 'Hotels',  'created_at' => '2020-12-28 18:27:36', 'updated_at' => '2020-12-30 19:15:30'
            ]
        ];

        foreach ($vendors as $key => $val) {
            VendorMaster::create($val);
        }
    }
}
