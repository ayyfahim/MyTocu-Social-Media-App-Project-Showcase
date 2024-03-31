<?php

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $authorRole = Role::where('name', 'author')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::forceCreate([
            'name' => 'Emmanuel',
            'email' => 'contact@mytocu.com',
            'password' => Hash::make('Ombudsman18'),
            'gender' => 'male',
            'email_verified_at' => Carbon::now(),
            'birthdate' => Carbon::now()->format('Y-m-d H:i:s'),
            'country_id' => '230',
            'state_id' => '3821',
            'status' => '0',
        ]);

        $author = User::forceCreate([
            'name' => 'Author',
            'email' => 'author@mytocu.com',
            'password' => Hash::make('password'),
            'gender' => 'male',
            'email_verified_at' => Carbon::now(),
            'birthdate' => Carbon::now()->format('Y-m-d H:i:s'),
            'country_id' => '230',
            'state_id' => '3821',
            'status' => '0',
        ]);

        $user = User::forceCreate([
            'name' => 'Generic User',
            'email' => 'user@mytocu.com',
            'password' => Hash::make('password'),
            'gender' => 'male',
            'email_verified_at' => Carbon::now(),
            'birthdate' => Carbon::now()->format('Y-m-d H:i:s'),
            'country_id' => '230',
            'state_id' => '3821',
            'status' => '0',
        ]);

        $admin->roles()->attach($adminRole);
        $author->roles()->attach($authorRole);
        $user->roles()->attach($userRole);
    }
}
