<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\LoginLog;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function redirectTo()
    {
        //
        if(Auth::user()->can('admin area') || Auth::user()->hasRole('administrator')){
            return '/admin';
        }
        return '/';
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)//登入成功
    {
        if(!$user->email_verified_at){
            Auth::logout();

            return redirect(route('admin-login'))->with('message', '請先完成帳號驗證再進行登入!');
        }else{
            $data = [
                'user_id'=>$user->id,
                'IP'=>$request->getClientIp(),
                'result'=>'成功',
            ];
            LoginLog::create($data);

            $action_logs = ActionLog::where('change_column','[]'); // 登入立即清除空白紀錄
            if($action_logs)
                $action_logs->delete();

            if($request->get('login_by') == 'admin'){ //判斷是否透過後台登入
                return redirect('/admin');
            }else{
                return redirect(route('index'));
            }
        }
    }
    protected  function sendFailedLoginResponse(Request $request)//登入失敗
    {
        $user = User::where('email',$request->get('email'))->first();
        if($user){
            $data = [
                'user_id'=>$user->id,
                'IP'=>$request->getClientIp(),
                'result'=>'帳號密碼錯誤',
            ];
            LoginLog::create($data);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

}
