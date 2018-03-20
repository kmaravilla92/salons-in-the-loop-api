<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        factory(App\User::class, 25)->make()->each(function($user) use($faker)
        {

            $user_arr = $user->toArray();
            $user_arr['password'] = $user->password;

            $user_role = $user_arr['user_role'];
            $user_role = ucfirst($user_role);

            unset(
                $user_arr['user_role'],
                $user_arr['full_name'],
                $user_arr['profile_pic'],
                $user_arr['profile'],
                $user_arr['pro_profile'],
                $user_arr['client_profile'],
                $user_arr['owner_profile']
            );

            $sentinel_user = Sentinel::registerAndActivate($user_arr);
            $role = Sentinel::findRoleByName($user_role.'s');
            $role->users()->attach($sentinel_user);

            $laravel_user = App\User::find($sentinel_user->id);
            $this->buildUserProfileByType($faker, $laravel_user, $sentinel_user, strtolower($user_role));
        });
    }

    protected function buildUserProfileByType($faker, $laravel_user, $sentinel_user, $type)
    {
        if(empty($sentinel_user->id)){
            dd($sentinel_user);
        }
        switch($type){
                case 'client':
                    $laravel_user
                        ->clientProfile()
                        ->create([
                            'user_id' => $sentinel_user->id,
                            'address'=>$faker->streetAddress,
                            'city'=>$faker->city,
                            'state'=>$faker->state,
                            'zip_code'=>$faker->postCode,
                            'allergy_list' => json_encode([["title"=>""],["title"=>""],["title"=>""]]),
                            'chemical_list' => json_encode([["title"=>""],["title"=>""],["title"=>""]]),
                            'likes' => json_encode([["title"=>""],["title"=>""],["title"=>""]]),
                            'dislikes' => json_encode([["title"=>""],["title"=>""],["title"=>""]]),
                        ]);
                break;
                case 'owner':
                    $laravel_user
                        ->ownerProfile()
                        ->create([
                            'user_id' => $sentinel_user->id,
                            'business_name' => $faker->company,
                            'title' => $faker->title,
                            'name' => $faker->name,
                            'address'=>$faker->streetAddress,
                            'city'=>$faker->city,
                            'state'=>$faker->state,
                            'general_space_description' => $faker->realText(75),
                            'category' => json_encode([])
                        ]);
                break;
                case 'professional':
                    $laravel_user
                        ->proServiceHours()
                        ->create([
                            'professional_id' => $sentinel_user->id,
                            'service_hours' => config('settings.professionals.default_service_hours'),
                        ]);
                    $laravel_user
                        ->proProfile()
                        ->create([
                            'user_id' => $sentinel_user->id,
                            'address'=>$faker->streetAddress,
                            'city'=>$faker->city,
                            'state'=>$faker->state,
                        ]);
                break;
            }
    }
}
