<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            'Admins' => [
                'permissions'   =>  [
                    'admin' =>  true
                ]
            ],
            'Users' =>  [
                'permissions'   =>  [
                    'user'  =>  true
                ]
            ],
            'Clients'   =>  [
                'permissions'    =>  [
                    'client'    =>  true
                ]
            ],
            'Owners' =>  [
                'permissions'    =>  [
                    'owner'    =>  true
                ]
            ],
            'Professionals' =>  [
                'permissions'    =>  [
                    'professional'    =>  true
                ]
            ]
        ];

        foreach($roles as $role_name => $role) {
            Sentinel::getRoleRepository()->createModel()->create([
                'name'          => $role_name,
                'slug'          => array_keys($role['permissions'])[0],
                'permissions'   => $role['permissions']
            ]);
        }
    }
}
