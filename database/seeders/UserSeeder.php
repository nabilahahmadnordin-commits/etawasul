<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'ela',
            'email' => 'ela@test.com',
            'password' => 'ela1234',
        ]);
        $user->assignRole(Role::where('name', 'admin')->first());


         $user = User::create([
            'name' => 'student ela',
            'email' => 'ela2@test.com',
            'password' => 'ela1234',
        ]);
        $user->assignRole(Role::where('name', 'student')->first());


         $user = User::create([
            'name' => 'kin ela',
            'email' => 'ela3@test.com',
            'password' => 'ela1234',
        ]);
        $user->assignRole(Role::where('name', 'kin')->first());
    }
}
