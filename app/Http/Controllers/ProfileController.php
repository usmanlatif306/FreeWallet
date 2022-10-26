<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function personalInfo(Request $request, $lang)
    {
        // if user has not 2fa verifies
        if (!auth()->user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        return view('profile.info');
    }

    public function impersonateUser(Request $request, $lang, $user_id)
    {

        if (Auth::user()->role_id != 1) {
            return back();
        }
        $user = User::FindOrFail($user_id);
        Auth::user()->impersonate($user);
        // if user has not 2fa verifies
        if (!Auth::user()->enabled_2fs()) {
            return redirect()->route('show2faForm', app()->getLocale());
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }

        return redirect(app()->getLocale() . '/home');
    }

    public function getUsers(Request $request, $lang)
    {
        if (Auth::User()->role_id != 1) {
            return back();
        }

        $users = User::paginate(10);

        return view('users.index')->with('users', $users);
    }

    public function storePersonalInfo(Request $request, $lang)
    {

        $this->validate($request, [
            'avatar' => 'required|mimes:jpeg,jpg,png',
            'firstName'    =>  'required',
            'lastName'    =>    'required'
        ]);

        $user = Auth::user();


        $file = $request->file('avatar');

        $filename = hash('sha1', $file->getClientOriginalName() . '-' . time()) . '.' . $file->getClientOriginalExtension();

        $filePath = 'users/' . Auth::user()->name . '/' . $filename;

        $image = Image::make($file);
        $image->fit(200, 200);



        if (Storage::put($filePath, (string) $image->encode())) {

            $user->avatar = Storage::url($filePath);
        } else {
            return back();
        }

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;

        $user->save();

        flash(__('Profile info updated with success '), 'success');
        return back();
    }

    public function newpasswordInfo(Request $request, $lang)
    {
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        return view('profile.newpassword');
    }

    public function storeNewpasswordInfo(Request $request, $lang)
    {
        if (setting('site.demo_mode')) {
            //TODO NOTHING
        } else {
            return back();
        }
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }

        $this->validate($request, [
            'newpassword' => 'required|min:6',
            'newpasswordagain'    =>  'required|same:newpassword',
            'oldpassword'    =>    'required'
        ]);

        if (Auth::user()->email == 'demouser@demouser.com' or Auth::user()->email == 'admin@admin.com') {
            flash(__('Please Do not change the password of a demonstration account'), 'success');
            return back();
        }

        if (password_verify($request->oldpassword, Auth::user()->password)) {
            $user = Auth::user();
            $user->password = bcrypt($request->newpassword);
            $user->save();
            flash(__('Password changed with success'), 'success');
        } else {

            flash('The old password is incorrect. ', 'danger');
        }

        return back();
    }

    public function profileIdentity(Request $request, $lang)
    {
        if (Auth::user()->currentWallet() == null) {
            return redirect(route('show.currencies', app()->getLocale()));
        }
        return view('profile.identity');
    }

    public function storeProfileIdentity(Request $request, $lang)
    {

        $this->validate($request, [
            'document' => 'required|mimes:jpeg,jpg,png'
        ]);

        $file = $request->file('document');

        $filename = hash('sha1', $file->getClientOriginalName() . '-' . time()) . '.' . $file->getClientOriginalExtension();
        $filePath = 'users/' . Auth::user()->name;
        $file->storeAs($filePath, $filename);

        $profile = Profile::where('user_id', Auth::user()->id)->first();

        if ($profile != null) {
            $profile->document = $filePath . '/' . $filename;
            $profile->save();
        } else {
            Profile::create([
                'user_id'    =>    Auth::user()->id,
                'document'    =>  $filePath . '/' . $filename
            ]);
        }

        return back();
    }

    public function me(Request $request, $lang, $username)
    {
        $user = User::where('name', $username)->first();

        if ($user == null) {
            abort(404);
        }

        $qrcode = base64_encode(json_encode([
            'res_type' => 'user_profile',
            'res_code' => $user->email,
            'res_act' => 'send'
        ]));



        return view('me.index')->with('user', $user)->with('QrCode', $qrcode);
    }
}
