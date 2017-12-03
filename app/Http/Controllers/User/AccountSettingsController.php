<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User as UserEntity;
use Hash;

class AccountSettingsController extends Controller
{

	protected $_user = null;

	public function __construct(Request $request)
	{
		$this->_user = UserEntity::where('id', $request->input('id'))->first();
	}

	public function getSettings()
	{
	
		$user = $this->getUser();

		return response()->json([
			'change_email' =>  [
				'id' => $user->id,
				'email' => $user->email,
				'current_password' => '',
			],
			'change_password' => [
				'id' => $user->id,
				'current_password' => '',
				'new_password' => '',
				'new_password_confirmation' => '',
			]
		]);
	}

	public function postChangeEmail(Request $request)
	{
		$response = [
			'messages' => [],
			'success' => false
		];

		$id = $request->input('id');
		$email = $request->input('email');
		$current_password = $request->input('current_password');


		$user = $this->getUser();
		$old_email = $user->email;

		$other_user = UserEntity::where('email', $email)
							->where('id', '!=', $id)
							->first();

		if($other_user){
			$response['messages'][] = 'Email has already been taken.';
		}else{
			if(!$this->_checkCurrentPassword($user, $current_password)){
				$response['messages'][] = 'Incorrect current password.';
			}else{
				$user->email = $email;
				if($response['success'] = $user->save()){
					if($email == $old_email){
						$response['messages'][] = 'Nothing has changed.';
					}else{
						$response['messages'][] = 'Email successfully changed.';
					}
				}
			}
		}
		return response()->json($response);
	}

	public function postChangePassword(Request $request)
	{
		$response = [
			'messages' => [],
			'success' => false
		];

		$id = $request->input('id');
		$current_password = $request->input('current_password');
		$new_password = $request->input('new_password');
		$new_password_confirmation = $request->input('new_password_confirmation');

		$user = $this->getUser();
		$old_password = $user->password;

		if($new_password != $new_password_confirmation){
			$response['messages'][] = 'Passwords does not match.';
		}else{
			if(!$this->_checkCurrentPassword($user, $current_password)){
				$response['messages'][] = 'Incorrect current password.';
			}else{
				if($this->_checkCurrentPassword($user, $new_password)){
					$response['messages'][] = 'Nothing has changed.';
				}else{
					$user->password = Hash::make($new_password);
					if($response['success'] = $user->save()){
						$response['messages'][] = 'Password successfully changed.';
					}
				}
				
			}
		}
		return response()->json($response);
	}

	protected function getUser()
	{
		return $this->_user;
	}

	protected function _checkCurrentPassword(UserEntity $user, $password)
	{
		return Hash::check($password, $user->password);
	}
}