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
    public function redirectToOAuth(Request $request,$provider,$redirectURL)
    {
        $binding = $request->get('binding') ?? 0;
        if ($provider === 'google' || $provider === 'facebook') {
            $parameter = json_encode(['redirectURL'=>$redirectURL,'binding'=>$binding]);
            return Socialite::driver($provider)->with(['state' => "parameter=$parameter"])->redirect();
        } else {
            return abort(401);
        }
    }

    public function handleOAuthCallback(Request $request,$provider)
    {
        $state = $request->input('state');
        parse_str($state, $result);
        $parameter = json_decode($result['parameter']);
        $binding = $parameter->binding;
        $redirect = $parameter->redirectURL;


        $oauthUser = Socialite::driver($provider)->stateless()->user();
        if($binding){
            $alreadyBindingSocial = User::where($provider,$oauthUser->id)->first();

            if($alreadyBindingSocial){
                return redirect(route($redirect))->with('Errormessage', $provider.'帳號已被綁定其他帳號!');
            }

            $user = Auth::user();
            $data=[
                $provider=>$oauthUser->id,
            ];
            $user->fill($data);
            $user->save();

            return redirect(route($redirect));
        }


        if($provider === 'google'){
            $alreadyGoogleUser = User::where('google',$oauthUser->id)->first();
            if($alreadyGoogleUser){
                Auth::loginUsingId($alreadyGoogleUser->id);
            }else{
                $userEmailCheck = User::where('email',$oauthUser->email)->first();
                if($userEmailCheck){
                    return redirect(route($redirect))->with('Errormessage', 'Email已經被註冊過!');
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
                    return redirect(route($redirect))->with('Errormessage', 'Email已經被註冊過!');
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


    public function BindingRedirectToOAuth($provider)
    {
        if ($provider === 'google' || $provider === 'facebook') {
            return Socialite::driver($provider)->with(['redirect'=>'test'])->redirect();
        } else {
            return abort(401);
        }
    }


}
