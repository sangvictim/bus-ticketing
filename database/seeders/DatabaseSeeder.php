<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Armada;
use App\Models\City;
use App\Models\Classes;
use App\Models\Facility;
use App\Models\Permission;
use App\Models\Price;
use App\Models\Role;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $permission =
            [
                "*",
                "permission.*", "permission.view",
                "role.*", "role.create", "role.view", "role.update", "role.delete",
                "user.*", "user.create", "user.view", "user.update", "user.delete",
            ];
        $role = ['super admin', 'admin'];

        for ($i = 0; $i < count($permission); $i++) {
            Permission::factory()->create([
                'name' => $permission[$i],
                'guard_name' => 'admin'
            ]);
        }

        for ($i = 0; $i < count($role); $i++) {
            Role::factory()->create([
                'name' => $role[$i],
                'guard_name' => 'admin'
            ])->givePermissionTo('*');
        }

        Admin::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt(123), //123
        ])->assignRole(1);

        Admin::factory()->create([
            'name' => 'Admin',
            'email' => 'user@mail.com',
            'password' => bcrypt(123), //123
        ])->assignRole(2);

        User::factory(10)->create();

        Armada::factory(50)->create();

        $fasilitas = [
            'Reclining Seat 1-1(2)',
            'AC',
            'Toilet',
            'LCD TV',
            'Musik',
            'Selimut',
            'Bantal',
            'Guling',
            'Layanan Makan Take Order',
            'Snack',
            'Free Air Mineral',
            'Free Wifi',
            'Layanan Pramugara/i',
        ];

        for ($i = 0; $i < count($fasilitas); $i++) {
            Facility::factory()->create([
                'name' => $fasilitas[$i],
            ]);
        }

        for ($i = 1; $i <= 10; $i++) {
            foreach (range('A', 'D') as $seats) {
                if ($seats === 'A' || $seats === 'D') {
                    $descSeat = 'Window Seat';
                } else {
                    $descSeat = 'Aisle Seat';
                }
                Seat::factory()->create([
                    'seat_number' => $i . $seats,
                    'description' => $descSeat,
                ]);
            }
        }

        $kelas_armada = [
            'First Class Double Decker',
            'Super Top Double Decker',
            'Executive Plus Double Decker',
            'Super Top SHD',
            'Executive Plus UHD',
            'Executive Plus SHD',
            'Super Executive',
            'Executive Class',
            'Bisnis AC Toilet (VIP)',
            'Bisnis AC (PATAS)'
        ];

        for ($i = 0; $i < count($kelas_armada); $i++) {
            Classes::factory()->create([
                'name' => $kelas_armada[$i],
            ]);
        }

        $facility = Facility::all();
        $seat = Seat::all();
        Classes::all()->each(function ($class) use ($facility, $seat) {
            $class->facilities()->attach($facility);
            $class->seats()->attach($seat);
        });

        Armada::all()->each(function ($armada) {
            $classes = Classes::all()->random(3)->pluck('id');
            $armada->classes()->attach($classes);
        });


        /**
         * seeder untuk kota dan agen
         */
        $agentOfCity = file_get_contents(__DIR__ . '/list-agen.json');
        $agentOfCity = json_decode($agentOfCity);
        foreach ($agentOfCity as $key => $value) {
            City::factory()->create([
                'name' => $value->text,
            ]);
            foreach ($value->children as $val) {
                Agent::factory()->create([
                    'city_id' => City::where('name', $value->text)->first()->id,
                    'name' => $val->name,
                    'address' => $val->text
                ]);
            }
        }

        $routes = [
            [
                "name" => "TANGERANG - PEMALANG",
                "origin_city" => 57,
                "destination_city" => 42,
                "estimated_duration" => 380
            ],
            [
                "name" => "PEMALANG - TANGERANG",
                "origin_city" => 42,
                "destination_city" => 57,
                "estimated_duration" => 380
            ],
            [
                "name" => "TANGERANG - PURBALINGGA",
                "origin_city" => 57,
                "destination_city" => 47,
                "estimated_duration" => 380
            ],
            [
                "name" => "PURBALINGGA - TANGERANG",
                "origin_city" => 47,
                "destination_city" => 57,
                "estimated_duration" => 380
            ],
            [
                "name" => "TANGERANG - PURWOKERTO",
                "origin_city" => 57,
                "destination_city" => 48,
                "estimated_duration" => 380
            ],
            [
                "name" => "PURWOKERTO - TANGERANG",
                "origin_city" => 48,
                "destination_city" => 57,
                "estimated_duration" => 380
            ],
            [
                "name" => "TANGERANG - CILACAP",
                "origin_city" => 57,
                "destination_city" => 12,
                "estimated_duration" => 380
            ],
            [
                "name" => "CILACAP - TANGERANG",
                "origin_city" => 12,
                "destination_city" => 57,
                "estimated_duration" => 380
            ],
        ];

        foreach ($routes as $key => $value) {
            Route::create($value);
        }

        $routes = Route::all();
        $classes = Classes::all();
        foreach ($routes as $key => $route) {
            foreach ($classes as $key => $class) {
                Price::factory()->create([
                    'route_id' => $route->id,
                    'class_id' => $class->id
                ]);
            }
        }

        foreach ($routes as $key => $value) {
            Schedule::factory()->create([
                'route_id' => $value->id,
                'armada_id' => $key + 1,
                'arrival_time' => '0' . ($key + 5) . ':00:00',
                'departure_time' => '0' . ($key + 5) . ':15:00',
            ]);
        }
    }
}
