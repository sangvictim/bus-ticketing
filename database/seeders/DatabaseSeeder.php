<?php

namespace Database\Seeders;

use App\Models\Cms\Admin;
use App\Models\Cms\Agent;
use App\Models\Cms\Buses;
use App\Models\Cms\City;
use App\Models\Cms\Classes;
use App\Models\Cms\Facility;
use App\Models\Cms\PaymentMethod;
use App\Models\Cms\Permission;
use App\Models\Cms\Price;
use App\Models\Cms\Role;
use App\Models\Cms\Route;
use App\Models\Cms\Schedule;
use App\Models\Cms\Seat;
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
    $permission =
      [
        "*",
        "permission.*",
        "permission.view",
        "role.*",
        "role.create",
        "role.view",
        "role.update",
        "role.delete",
        "admin.*",
        "admin.create",
        "admin.view",
        "admin.update",
        "admin.delete",
        "log.*",
        "log.view",
        "payment-method.*",
        "payment-method.create",
        "payment-method.view",
        "payment-method.update",
        "payment-method.delete",
        "transaction.*",
        "transaction.view",
        "user.*",
        "user.view",
        "agent.*",
        "agent.create",
        "agent.view",
        "agent.update",
        "agent.delete",
        "city.*",
        "city.create",
        "city.view",
        "city.update",
        "city.delete",
        "price.*",
        "price.create",
        "price.view",
        "price.update",
        "price.delete",
        "routes.*",
        "routes.create",
        "routes.view",
        "routes.update",
        "routes.delete",
        "schedule.*",
        "schedule.create",
        "schedule.view",
        "schedule.update",
        "schedule.delete",
        "bus.*",
        "bus.create",
        "bus.view",
        "bus.update",
        "bus.delete",
        "bus-classes.*",
        "bus-classes.create",
        "bus-classes.view",
        "bus-classes.update",
        "bus-classes.delete",
        "facility.*",
        "facility.create",
        "facility.view",
        "facility.update",
        "facility.delete",
        "seat.*",
        "seat.create",
        "seat.view",
        "seat.update",
        "seat.delete",
      ];

    for ($i = 0; $i < count($permission); $i++) {
      Permission::factory()->create([
        'name' => $permission[$i],
        'guard_name' => 'admin'
      ]);
    }

    Role::factory()->create([
      'name' => 'super admin',
      'guard_name' => 'admin'
    ])->givePermissionTo('*');
    Role::factory()->create([
      'name' => 'admin',
      'guard_name' => 'admin'
    ])->givePermissionTo(Permission::where('id', '>', 20)->get());

    Admin::factory()->create([
      'name' => 'Super Admin',
      'email' => 'super@mail.com',
      'password' => bcrypt(123), //123
    ])->assignRole(1);

    Admin::factory()->create([
      'name' => 'Admin',
      'email' => 'admin@mail.com',
      'password' => bcrypt(123), //123
    ])->assignRole(2);

    User::factory(25)->create();

    Buses::factory(50)->create();

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

    Buses::all()->each(function ($bus) {
      $classes = Classes::all()->random(3)->pluck('id');
      $bus->classes()->attach($classes);
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
        "origin_city" => "TANGERANG",
        "destination_city" => "PEMALANG",
        "estimated_duration" => 380
      ],
      [
        "name" => "PEMALANG - TANGERANG",
        "origin_city" => "PEMALANG",
        "destination_city" => "TANGERANG",
        "estimated_duration" => 380
      ],
      [
        "name" => "TANGERANG - PURBALINGGA",
        "origin_city" => "TANGERANG",
        "destination_city" => "PURBALINGGA",
        "estimated_duration" => 380
      ],
      [
        "name" => "PURBALINGGA - TANGERANG",
        "origin_city" => "PURBALINGGA",
        "destination_city" => "TANGERANG",
        "estimated_duration" => 380
      ],
      [
        "name" => "TANGERANG - PURWOKERTO",
        "origin_city" => "TANGERANG",
        "destination_city" => "PURWOKERTO",
        "estimated_duration" => 380
      ],
      [
        "name" => "PURWOKERTO - TANGERANG",
        "origin_city" => "PURWOKERTO",
        "destination_city" => "TANGERANG",
        "estimated_duration" => 380
      ],
      [
        "name" => "TANGERANG - CILACAP",
        "origin_city" => "TANGERANG",
        "destination_city" => "CILACAP",
        "estimated_duration" => 380
      ],
      [
        "name" => "CILACAP - TANGERANG",
        "origin_city" => "CILACAP",
        "destination_city" => "TANGERANG",
        "estimated_duration" => 380
      ],
    ];

    foreach ($routes as $key => $value) {
      $cityOrigin = City::where('name', $value['origin_city'])->first();
      $cityDestination = City::where('name', $value['destination_city'])->first();

      if ($cityOrigin && $cityDestination) {
        Route::create([
          'name' => $value['name'],
          'origin_city' => $cityOrigin->id,
          'destination_city' => $cityDestination->id,
          'estimated_duration' => $value['estimated_duration']
        ]);
      }
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
      $bus = Buses::all()->random(1)->first();
      Schedule::factory()->create([
        'route_id' => $value->id,
        'buses_id' => $bus->id,
        'arrival_time' => '0' . ($key + 5) . ':00:00',
        'departure_time' => '0' . ($key + 5) . ':15:00',
      ]);
    }

    /**
     * seeder untuk payment method
     */
    $channels = [
      [
        'name' => 'Virtual Accounts',
        'code' => 'VA',
        'sort' => 0
      ],
      [
        'name' => 'Retail Outlets (OTC)',
        'code' => 'OTC',
        'sort' => 1
      ],
      [
        'name' => 'eWallets',
        'code' => 'EWALLET',
        'sort' => 2
      ],
      [
        'name' => 'QR Codes',
        'code' => 'QR',
        'sort' => 3
      ],
      [
        'name' => 'Paylater',
        'code' => 'PAYLATER',
        'sort' => 4
      ]
    ];

    $ewallets = [
      [
        'name' => 'OVO',
        'code' => 'ID_OVO',
        'sort' => 0
      ],
      [
        'name' => 'DANA',
        'code' => 'ID_DANA',
        'sort' => 1
      ],
      [
        'name' => 'SHOPEEPAY',
        'code' => 'ID_SHOPEEPAY',
        'sort' => 2
      ],
      [
        'name' => 'LINKAJA',
        'code' => 'ID_LINKAJA',
        'sort' => 3
      ]
    ];

    foreach ($channels as $key => $value) {
      PaymentMethod::create([
        'name' => $value['name'],
        'code' => $value['code'],
        'sort' => $value['sort'],
        'country' => 'ID',
        'currency' => 'IDR'
      ]);
    }
    $paymentMethods = file_get_contents(__DIR__ . '/list-va.json');
    $paymentMethods = json_decode($paymentMethods);
    foreach ($paymentMethods as $key => $value) {
      PaymentMethod::create([
        'parent' => 1,
        'icon' => 'https://placehold.co/600x400',
        'name' => $value->name,
        'code' => $value->code,
        'country' => $value->country,
        'currency' => $value->currency,
      ]);
    }

    foreach ($ewallets as $key => $value) {
      PaymentMethod::create([
        'parent' => 3,
        'icon' => 'https://placehold.co/600x400',
        'name' => $value['name'],
        'code' => $value['code'],
        'sort' => $value['sort'],
        'country' => 'ID',
        'currency' => 'IDR'
      ]);
    }
  }
}
