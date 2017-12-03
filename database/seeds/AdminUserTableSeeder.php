<?php

use Illuminate\Database\Seeder;

class AdminUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin_users = [
            [
                'first_name' => 'Kim',
                'last_name' => 'Maravilla',
                'email' => 'kim@happyweekend.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Prince',
                'last_name' => 'Gayares',
                'email' => 'prince@happyweekend.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Janina',
                'last_name' => 'Diesta',
                'email' => 'janina@happyweekend.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@happyweekend.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Happy',
                'last_name' => 'Developer',
                'email' => 'developer@happyweekend.com',
                'password' => '#p3a5s7s!'
            ],
        ];

        foreach($admin_users as $admin_user){
            $sentinel_user = Sentinel::registerAndActivate($admin_user);
            $admin_role = Sentinel::findRoleByName('Admins');
            $admin_role->users()->attach($sentinel_user);
        }
    }
}
