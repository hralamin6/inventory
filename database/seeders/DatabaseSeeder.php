<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create([
            'name'=>'hr alamin',
            'type'=>'admin',
            'phone'=>'01472583695',
            'email'=>'hralamin2020@gmail.com',
            'email_verified_at' => now(),
            'password'=>Hash::make('000000')
        ]);

//             \App\Models\User::factory(10)->create();
//             \App\Models\Category::factory(10)->create();
//             \App\Models\Brand::factory(10)->create();
//             \App\Models\Unit::factory(10)->create();
//             \App\Models\Product::factory(30)->create();
             \App\Models\Setup::factory(1)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
