<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rest\User\Store as StoreUser;
use App\User as UserEntity;
use App\Models\Entities\Image as ImageEntity;
use App\Events\User\Created as UserCreated;
use Sentinel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserEntity::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $response = [
            'messages' => [],
            'success' => false,
            'clear_form' => false,
            'redirect_to' => false
        ];

        try{
            $user_details = $request->input('user');
            $sentinel_user = Sentinel::registerAndActivate($user_details);

            $user_role = Sentinel::findRoleBySlug($user_details['type']);
            $user_role->users()->attach($sentinel_user);

            $laravel_user = \App\User::find($sentinel_user->id);
            unset($user_details['password']);
            $laravel_user->update($user_details);
            
            switch($user_details['type']){
                case 'client':
                    $laravel_user
                        ->clientProfile()
                        ->create([
                            'user_id' => $sentinel_user->id,
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
                        ]);
                break;
            }

            event(new UserCreated($laravel_user));
            $response['messages'][] = 'Successfully registered';
            $response['success'] = true;
        }catch(\Exception $e){
            $response['messages'][] = $e->getMessage();
        }

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id, Request $request)
    {
        $eloquent_user = new UserEntity;
        $sentinel_user = Sentinel::findById($user_id);

        $eloquent_user = $eloquent_user->with([
            'reviews',
        ]);

        if($sentinel_user->hasAccess('client')){
            $eloquent_user = $eloquent_user->with([
                'clientProfile',
                'images' => function($query){
                    $query->whereIn('type', ['current_look_photos', 'desired_look_photos']);
                },
            ]);
        }

        if($sentinel_user->hasAccess('owner')){
            $eloquent_user = $eloquent_user->with([
                'ownerProfile',
                'images' => function($query){
                    $query->whereIn('type', ['gallery_photos']);
                },
            ]);
        }

        if($sentinel_user->hasAccess('professional')){
            $eloquent_user = $eloquent_user->with([
                'proProfile',
                'proServices' => function($query)
                {
                    $query
                        ->where('status', '1');
                },
                'proServiceHours',
                'images' => function($query){
                    $query->whereIn('type', ['pro_photos','license_photos']);
                },
            ]);
        }

        $eloquent_user = $eloquent_user->where('id', $user_id)->first();
        
        if($eloquent_user){

            $user_arr = collect($eloquent_user)->map(function($value, $key){
                if(is_array($value)){
                    return collect($value)->map(function($value, $key){
                        if(is_string($value) && in_array($key, ['allergy_list', 'chemical_list', 'likes', 'dislikes'])){
                            return json_decode($value);
                        }
                        return $value;
                    });
                }
                return $value;
            })->toArray();
            
            $user_arr['images'] = collect($eloquent_user->images)->groupBy('type');
            $user_arr['images']->each(function($image, $key)use(&$user_arr){
                $user_arr[$key] = $image->toArray();
            });

            if($sentinel_user->hasAccess('client')){
                foreach(['current_look_photos', 'desired_look_photos'] as $_photo_type){
                    if(!isset($user_arr['images'][$_photo_type])){
                        $user_arr[$_photo_type] = [];
                    }
                }
            }

            if($sentinel_user->hasAccess('owner')){
                foreach(['gallery_photos'] as $_photo_type){
                    if(!isset($user_arr['images'][$_photo_type])){
                        $user_arr[$_photo_type] = [];
                    }
                }
            }

            if($sentinel_user->hasAccess('professional')){
                foreach(['pro_photos','license_photos'] as $_photo_type){
                    if(!isset($user_arr['images'][$_photo_type])){
                        $user_arr[$_photo_type] = [];
                    }
                }
            }

            $user_profile_pic = $eloquent_user->images()->where('type', 'user_profile_pic')->orderBy('id', 'DESC')->first();

            if(!$user_profile_pic){
                $user_arr['profile_pic'] = ['path'=>config('app.site_url') . '/frontsite/images/sitl-img.png', 'name'=>config('app.site_url') . '/frontsite/images/sitl-img.png'];
            }else{
                $user_arr['profile_pic'] = $user_profile_pic;
            }

            unset($user_arr['images']);
            // dd($user_arr);
            return response()->json($user_arr);
        }

        return null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user_id)
    {
        $user = new UserEntity;
        $sentinel_user = \Sentinel::findById($user_id);
        $user = $user->where('id', $user_id)->first();
        $user->update($request->all());
        $photo_types = [];

        if($sentinel_user->hasAccess('client')){
            $photo_types = $request->only([
                'current_look_photos',
                'desired_look_photos',
            ]);
        }

        if($sentinel_user->hasAccess('owner')){
            $photo_types = $request->only([
                'gallery_photos',
            ]);
        }

        if($sentinel_user->hasAccess('professional')){
            $photo_types = $request->only([
                'pro_photos',
                'license_photos',
            ]);
        }

        $photos_to_save = [];
        $photos_to_delete = [];
        
        $user->images()->whereIn('type', array_keys($photo_types))->delete();

        foreach($photo_types as $photo_type => $photos){
            if(count($photos)){
                foreach($photos as $photo){
                    $photos_to_save[] = new ImageEntity([
                        'name'      => $photo['name'],
                        'type'      => $photo['type'],
                        'type_id'   => $photo['type_id'],
                        'path'      => $photo['path'],
                        'status'    => '1'
                    ]);
                }
            }
        }

        if(count($photos_to_save)){
            $user->images()->saveMany($photos_to_save);
        }

        // var_dump($request->input('profile_pic'));dd([]);
        if($request->input('profile_pic.path')){
            ImageEntity::create([
                'name'      => $request->input('profile_pic.name'),
                'type'      => 'user_profile_pic',
                'type_id'   => $sentinel_user->id,
                'path'      => $request->input('profile_pic.path'),
                'status'    => '1'
            ]);
        }else{
            $profile_pics = ImageEntity::where('type', 'user_profile_pic')->where('type_id', $sentinel_user->id);
            $profile_pics->delete();
        }

        if($sentinel_user->hasAccess('client')){
            $client_profile_input = $request->only([
                'client_profile.user_id',
                'client_profile.address',
                'client_profile.city',
                'client_profile.state',
                'client_profile.zip_code',
                'client_profile.allergy_list',
                'client_profile.chemical_list',
                'client_profile.likes',
                'client_profile.dislikes',
            ])['client_profile'];
            
            $client_profile = collect($client_profile_input)->map(function($value){
                if(is_array($value)){
                    return json_encode($value);
                }
                return $value;
            })->toArray();

            $user->clientProfile()->updateOrCreate(
                [
                    'user_id' => $sentinel_user->id
                ],
                $client_profile
            );
        }

        if($sentinel_user->hasAccess('owner')){
            $owner_profile_input = $request->only([
                'owner_profile.user_id',
                'owner_profile.category',
                'owner_profile.category_decoded',
                'owner_profile.business_name',
                'owner_profile.title',
                'owner_profile.name',
                'owner_profile.address',
                'owner_profile.city',
                'owner_profile.state',
                'owner_profile.general_space_description',
            ])['owner_profile'];

            $owner_profile_input['category'] = $owner_profile_input['category_decoded'];
            unset($owner_profile_input['category_decoded']);
            
            $owner_profile = collect($owner_profile_input)->map(function($value){
                if(is_array($value)){
                    return json_encode($value);
                }
                return $value;
            })->toArray();

            $user->ownerProfile()->updateOrCreate(
                [
                    'user_id' => $sentinel_user->id
                ],
                $owner_profile
            );
        }

        if($sentinel_user->hasAccess('professional')){
            $pro_profile_input = $request->only([
                'pro_profile.user_id',
                'pro_profile.category',
                'pro_profile.category_decoded',
                'pro_profile.address',
                'pro_profile.city',
                'pro_profile.state',
                'pro_profile.zipcode',
                'pro_profile.cancellation_policy',
                'pro_profile.social_link_facebook',
                'pro_profile.social_link_instagram',
                'pro_profile.social_link_twitter',
            ])['pro_profile'];

            $pro_profile_input['category'] = $pro_profile_input['category_decoded'];
            unset($pro_profile_input['category_decoded']);

            $pro_profile = collect($pro_profile_input)->map(function($value){
                if(is_array($value)){
                    return json_encode($value);
                }
                return $value;
            })->toArray();

            $user->proProfile()->updateOrCreate(
                [
                    'user_id' => $sentinel_user->id
                ],
                $pro_profile
            );
        }

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
