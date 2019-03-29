<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => 'Majd',
            'email' => 'superuser@bassoumi.org',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make(123123), // password
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        factory(\Bassoumi\User::class, 1234)->create();
    }
}
