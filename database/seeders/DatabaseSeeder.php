<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\ClassArmada;
use App\Models\Classes;
use App\Models\Facility;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\Seat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use KodePandai\Indonesia\IndonesiaDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(IndonesiaDatabaseSeeder::class);

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
                'guard_name' => 'web'
            ]);
        }

        for ($i = 0; $i < count($role); $i++) {
            Role::factory()->create([
                'name' => $role[$i],
                'guard_name' => 'web'
            ])->givePermissionTo('*');
        }

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt(123), //123
        ])->assignRole(1);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'user@mail.com',
            'password' => bcrypt(123), //123
        ])->assignRole(2);

        Armada::factory(20)->create();

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

        // $agentOfCity = file_get_contents(__DIR__ . '/list-agen.json');
        // $agentOfCity = json_decode($agentOfCity);
    }
}
