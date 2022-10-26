<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(Request $request, $lang){
    	return view('demo.index');
    }

    public function user(Request $request, $lang){

        if (Auth::attempt(['email' => 'demouser@demouser.com', 'password' =>'123456'])) {
            
            return redirect(app()->getLocale().'/home');

        }
        abort(404);
    }
    public function admin(Request $request, $lang){
        if(Auth::check()){
            if(Auth::user()->email == 'demouser@demouser.com'){
                return redirect('/admin/dashboard');
            }
        }
    	 if (Auth::attempt(['email' => 'demouser@demouser.com', 'password' =>'123456'])) {
            
            return redirect('/admin/dashboard');

        }
        abort(404);
    }
}
