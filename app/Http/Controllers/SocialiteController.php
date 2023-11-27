<?php

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;


class SocialiteController extends Controller
{
    public function redirectToOAuth($provider)
    {
        if ($provider === 'google' || $provider === 'facebook') {
            return Socialite::driver($provider)->redirect();
        } else {
            return abort(401);
        }
    }

    public function handleOAuthCallback(Request $request,$provider)
    {
        $previousUrl = $request->session()->previousUrl();
        $previousArray = explode('/',$previousUrl);
        $redirect = end($previousArray);

        $oauthUser = Socialite::driver($provider)->user();
        if($provider === 'google'){
            $alreadyGoogleUser = User::where('google',$oauthUser->id)->first();
            if($alreadyGoogleUser){
                Auth::loginUsingId($alreadyGoogleUser->id);
            }else{
                $userEmailCheck = User::where('email',$oauthUser->email)->first();
                if($userEmailCheck){
                    $data=[
                        'google'=>$oauthUser->id,
                    ];
                    $userEmailCheck->fill($data);
                    $userEmailCheck->save();
                    Auth::loginUsingId($userEmailCheck->id);
                }else{
                    $data=[
                        'google'=>$oauthUser->id,
                        'name'=>$oauthUser->name,
                        'email'=>$oauthUser->email,
                        'password'=>Hash::make(uniqid()),
                        'status'=>1,
                        'email_verified_at' => date('Y-m-d H:i:s'),
                    ];
                    $user = User::create($data);
                    ActionLog::create_log($user,'新增');
                    Auth::loginUsingId($user->id);
                }
            }
            return redirect(route($redirect));
        }elseif ($provider === 'facebook'){
            $alreadyFBUser = User::where('facebook',$oauthUser->id)->first();
            if($alreadyFBUser){
                Auth::loginUsingId($alreadyFBUser->id);
            }else{
                $userEmailCheck = User::where('email',$oauthUser->email)->first();
                if($userEmailCheck){
                    $data=[
                        'facebook'=>$oauthUser->id,
                    ];
                    $userEmailCheck->fill($data);
                    $userEmailCheck->save();
                    Auth::loginUsingId($userEmailCheck->id);
                }else{
                    $data=[
                        'facebook'=>$oauthUser->id,
                        'name'=>$oauthUser->name,
                        'email'=>$oauthUser->email,
                        'password'=>Hash::make(uniqid()),
                        'status'=>1,
                        'email_verified_at' => date('Y-m-d H:i:s'),
                    ];
                    $user = User::create($data);
                    ActionLog::create_log($user,'新增');
                    Auth::loginUsingId($user->id);
                }
            }
            return redirect(route($redirect));
        }else{
            return redirect(route($redirect))->with('Errormessage', '無法登入帳號!');
        }
    }


}
