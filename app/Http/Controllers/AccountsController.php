<?php

namespace App\Http\Controllers;


use Mail;
use App\User;
use App\Mail\resetEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
     
	public function validatePasswordRequest(Request $request){
		$user = DB::table('users')->where('email', '=', $request->email)
		    ->first();

		//Check if the user exists
		if (is_null($user)) {
		    return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
		}

		//Create Password Reset Token
		DB::table('password_resets')->insert([
		    'email' => $request->email,
		    'token' => str_random(60),
		    'created_at' => \Carbon\Carbon::now()
		]);
		//Get the token just created above
		$tokenData = DB::table('password_resets')
		    ->where('email', $request->email)->first();

		if ($this->sendResetEmail($request->email, $tokenData->token)) {
		    return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
		} else {
		    return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
		}

		dd('guij');
	}

	public function resetPassword(Request $request, $lang){
		//Validate input
	    $this->validate($request, [
	        'email' => 'required|email|exists:users,email',
	        'password' => 'required|confirmed',
	        'token' => 'required' 
	    ]);

	    // //check if payload is valid before moving on
	    // if ($validator->fails()) {
	    //     return redirect()->back()->withErrors(['email' => 'Please complete the form']);
	    // }

	    $password = $request->password;
		// Validate the token
		    $tokenData = DB::table('password_resets')
		    ->where('token', $request->token)->first();
		// Redirect the user back to the password reset request form if the token is invalid
		    if (!$tokenData) return view('auth.passwords.email');

		    $user = User::where('email', $tokenData->email)->first();
		// Redirect the user back if the email is invalid
		    if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
		//Hash and update the new password
		    $user->password = \Hash::make($password);
		    $user->update(); //or $user->save();

	    //login the user immediately they change password successfully
	    //Auth::login($user);

	    //Delete the token
	    DB::table('password_resets')->where('email', $user->email)
	    ->delete();

	    //Send Email Reset Success Email
	    //if ($this->sendSuccessEmail($tokenData->email)) {
	      
	        return redirect(app()->getLocale().'/');
	    // } else {
	    //     return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
	    // }
	}

	private function sendResetEmail($email, $token)
	{
		//Retrieve the user from the database
		$user = DB::table('users')->where('email', $email)->select('first_name', 'email')->first();
		//Generate, the password reset link. The token generated is embedded in the link
		$link = url('/').'/'. app()->getLocale() . '/password/reset/' . $token . '/' . urlencode($user->email);

		    try {
		    	Mail::send(new resetEmail( $user->email, $link));
		        return true;
		    } catch (\Exception $e) {
		        return false;
		    }
	}

	public function showResetForm(Request $request,$lang, $token){
		return view('auth.passwords.reset')->with(['token' => $token, 'email' => $request->email]);

	}


}
