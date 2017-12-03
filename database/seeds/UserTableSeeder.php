<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 25)->make()->each(function($user){

            $user_arr = $user->toArray();
            $user_arr['password'] = $user->password;

            $user_role = $user_arr['user_role'];
            $user_role = ucfirst($user_role);

            unset($user_arr['user_role']);

            $sentinel_user = Sentinel::registerAndActivate($user_arr);
            $role = Sentinel::findRoleByName($user_role.'s');
            $role->users()->attach($sentinel_user);
        });
    }
}
