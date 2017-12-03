<?php

namespace App\Http\Controllers\Backoffice\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
use Auth;

class LogoutController extends Controller
{
    public function __invoke()
    {
    	$currentUser = Sentinel::getUser();
    	Sentinel::logout();
    	Auth::logout();
    	if($currentUser && $currentUser->hasAccess('admin')){
    		return redirect(route('admin.login'));
    	}
        return redirect('/');
    }
}
