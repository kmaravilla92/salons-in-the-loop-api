<?php

use Illuminate\Database\Seeder;

class InfoUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $info_users = [
            [
                'first_name' => 'Kim',
                'last_name' => 'Maravilla ( INFO )',
                'email' => 'kimluari+info@gmail.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Happy',
                'last_name' => 'Weekend ( INFO )',
                'email' => 'happiweekend+info@gmail.com',
                'password' => '#p3a5s7s!'
            ],
            [
                'first_name' => 'Salons in',
                'last_name' => 'the Loop ( INFO )',
                'email' => 'info@salonsintheloop.com',
                'password' => '#p3a5s7s!'
            ],
        ];

        foreach($info_users as $info_user){
            $sentinel_user = Sentinel::registerAndActivate($info_user);
            $user_role = Sentinel::findRoleByName('Users');
            $user_role->users()->attach($sentinel_user);
        }
    }
}
