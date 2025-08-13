<?php

namespace App\Http\Controllers;

use Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;
use DerekCodes\TurnstileLaravel\TurnstileLaravel;

class LoginController extends Controller
{
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function showResetPasswordForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function lupa_password()
    {
        return view('lupa_password');
    }
    public function sendLink(Request $req)
    {
        if ($req->get('cf-turnstile-response') == null) {
            return back()->with('captcha', 'Checklist Captcha');
        } else {
            $turnstile = new TurnstileLaravel;
            $response = $turnstile->validate($req->get('cf-turnstile-response'));
            if ($response['status'] == true) {
                if (User::where('email', $req->email)->first() == null) {
                    $req->flash();
                    return redirect()->back()->with('error', 'E-mail Tidak ditemukan');
                } else {
                    $req->validate(['email' => 'required|email']);

                    $status = Password::sendResetLink(
                        $req->only('email')
                    );

                    if ($status === Password::RESET_THROTTLED) {

                        return redirect()->back()->with(['email' => 'Terlalu banyak permintaan. Silakan coba lagi dalam beberapa menit.']);
                    }

                    if ($status === Password::RESET_LINK_SENT) {
                        $req->flash();
                        return redirect()->back()->with(['status' => __($status)]);
                    } else {

                        Log::error('Reset link error: ' . __($status));

                        return redirect()->back()->with(['email' => __($status)]);
                    }
                }
            } else {
                $req->flash();
                return back()->with('error', 'Check Captcha');
            }
        }
    }
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->roles === 'user') {
                return redirect('/user/home');
            } else {
                return redirect('/admin/home');
            }
        }
        return view('login');
    }
    public function login(Request $req)
    {
        // if ($req->get('cf-turnstile-response') == null) {

        //     return back()->with('captcha', 'Checklist Captcha');
        // } else {
        // $turnstile = new TurnstileLaravel;
        // $response = $turnstile->validate($req->get('cf-turnstile-response'));

        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // if ($response['status'] == true) {

        // $remember = $req->remember ? true : false;
        $credential = $req->only('username', 'password');

        if (Auth::attempt([$field => $login, 'password' => request()->password], true)) {

            if (Auth::user()->roles === 'user') {
                return redirect('/user/home');
            } else {
                return redirect('/admin/home');
            }
        } else {
            $req->flash();
            return redirect('/login')->with('error', 'Wrong Username Or Password');
        }
        // } else {
        //     $req->flash();
        //     return back()->with('error', 'Check Captcha');
        // }
        // }
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleProviderCallback()
    {
        try {

            $user = Socialite::driver('google')->stateless()->user();
            //dd($user);
            $finduser = User::where('gauth_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);
                session()->regenerate();
                return redirect('/user/home');
            } else {
                $newProfile = new Profile();
                $newProfile->email = $user->email;
                $newProfile->save();

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => 'user',
                    'gauth_id' => $user->id,
                    'gauth_type' => 'google',
                    'password' => encrypt('user@123'),
                    'profile_id' => $newProfile->id,
                ]);
                $newUser->markEmailAsVerified();
                Auth::login($newUser);

                return redirect('/user/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
