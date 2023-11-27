<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::create([
            'name' => 'RHan',
            'email' => 'sir3453715@gmail.com',
            'password' => Hash::make('ji3rul4m3c/6YA'),
            'status' => '1',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $user->assignRole('administrator');

        $user = User::create([
            'name' => 'Hsien',
            'email' => 'hsienchannel@gmail.com',
            'password' => Hash::make('123456789'),
            'status' => '1',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $user->assignRole('manager');

        $manager_user = User::create([
            'name' => 'Manager',
            'email' => 'manager@a.com',
            'password' => Hash::make('111111'),
            'status' => '1',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $manager_user->assignRole('manager');

        $user = User::create([
            'name' => 'Customer',
            'email' => 'customer@a.com',
            'password' => Hash::make('111111'),
            'status' => '1',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        $user->assignRole('customer');


    }
}
