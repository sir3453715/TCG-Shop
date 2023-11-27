<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\FrequentContact;
use App\Models\User;
use App\Models\VendorStaff;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use function Sodium\randombytes_random16;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasRole(['vendor','staff']) ) {
            return redirect(route('admin.user.edit',['user'=>Auth::id()]));
        }

        $role_array = ['customer','staff','vendor','manager','administrator'];
        $queried = array();
        if(Auth::user()->hasRole('administrator')){
            $roles = Role::orderBy('id','ASC');
        }elseif(Auth::user()->hasRole('manager')){
            $roles = Role::where('name','!=','administrator')
                ->orderBy('id','ASC');
            $role_array = ['customer','manager','vendor'];
        }
        if($request->get('role')) {
            $role = Role::find($request->get('role'));
            if($role){
                $role_array = [$role->name];
                $queried['role'] = $request->get('role');
            }
        }

        $users = User::role($role_array);

        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $users = $users->where(function ($query) use ($keyword){
                $query->orwhere('name','LIKE','%'.$keyword.'%');
                $query->orwhere('email','LIKE','%'.$keyword.'%');
            });
            $queried['keyword'] = $request->get('keyword');
        }

        $users = $users->paginate(20);
        $userCounts = $roles->withCount('users')->get()->toArray();
        $roles = $roles->get();

        return view('admin.users.users',[
            'userCounts'=>$userCounts,
            'users'=>$users,
            'roles' => $roles,
            'queried' => $queried,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('administrator')) {
            $roles = Role::orderBy('id','DESC')
                ->get();
        }else{
            $role_array = ['customer','vendor'];
            $roles = Role::whereIn('name',$role_array)
                ->orderBy('id','DESC')
                ->get();
        }
        return view('admin.users.createUser',[
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->toArray(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|same:second_password',
            'second_password'=>'required',
        ]);
        if($validator->fails()){
            $message = '<ul>';
            foreach ($validator->errors()->all() as $text){
                $message .= '<li>'.$text.'</li>';
            }
            $message .= '</ul>';
            return back()->withInput()->with('error',$message);
        }else{
            $data=[
                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'password'=>Hash::make($request->get('password')),
                'status'=>0,
                'phone'=>$request->get('phone'),
            ];
            $user = User::create($data);
            ActionLog::create_log($user,'新增');

            if($request->get('users_role')){
                $role = Role::find($request->get('users_role'));
                if(!$user) {
                    $user->assignRole($role->name);
                }else{
                    $user->syncRoles($role->name);
                }
            }
            $user->SendEmailVerificationNotification();

            return redirect(route('admin.user.index'))->with('message', '帳號已建立!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(Auth::user()->hasRole('administrator')) {
            $roles = Role::orderBy('id','ASC')
                ->get();
        }else{
            $roles = Role::where('name','!=','administrator')
                ->orderBy('id','ASC')
                ->get();
        }

        return view('admin.users.editUser',[
            'user'=>$user,
            'roles' => $roles,
            'user_roles' => $user->roles()->first()->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $data=[
            'name'=>$request->get('name'),
            'status'=>($request->get('status'))??$user->status,
            'phone'=>$request->get('phone'),
        ];
        if($request->get('change_password')=='1'){
            if($request->get('password')){
                $data['password'] = Hash::make($request->get('password'));
            }
        }
        $user->fill($data);
        ActionLog::create_log($user);
        $user->save();

        if($request->get('users_role')){
            $role = Role::find($request->get('users_role'));
            if(!$user) {
                $user->assignRole($role->name);
            }else{
                $user->syncRoles($role->name);
            }
        }
        if(Auth::user()->hasRole('administrator')||Auth::user()->hasRole('manager')){
            return redirect(route('admin.user.index'))->with('message', '資料已更新!');
        }else{
            return redirect(route('admin.user.edit',[
                'user'=>Auth::id()
            ]))->with('message', '資料已更新!');
        }

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
        $user = User::find($id);
        if($user){
            $user->delete();
            ActionLog::create_log($user,'刪除');
        }

        return redirect(route('admin.user.index'))->with('message', '資料已刪除!');

    }

    public function verifiedMail(Request $request){
        $user = User::find($request->route('id'));

        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return redirect(route('index'))->with('Errormessage', '已經完成過驗證流程!請直接登入帳號!');
        }else{
            if ($user->markEmailAsVerified()) {
                event(new Verified($user));
            }
            $user->fill(['status'=>1]);
            ActionLog::create_log($user);
            $user->save();

            Auth::loginUsingId($request->route('id'));
            return redirect(route('index'))->with('message', '驗證成功!可以開始使用您的帳號!');
        }
    }
    public function resendConfirm($user_id){
        $user = User::find($user_id);

        $user->SendEmailVerificationNotification();

        return redirect(route('admin.user.index'))->with('message', '已重新發送驗證信!');
    }


    public function searchUser(Request $request){

        if($request->get('roles')){
            $role_array = explode(',',$request->get('roles'));
        }else{
            $role_array = ['customer','manager','vendor'];
        }
        if($request->get('keyword')){
            $keyword = $request->get('keyword');
            $usersQuery = User::role($role_array)
                ->where(function ($query) use ($keyword){
                    $query->orwhere('email','LIKE','%'.$keyword.'%');//產品編號
                    $query->orwhere('name','LIKE','%'.$keyword.'%');//產品標題
                });
            $users = $usersQuery->get();
        }else{
            $users = [];
        }
        return response()->json([
            'users' => $users
        ]);
    }

    public function getUser(Request $request){

        $user_id = $request->get('user_id');
        $user = User::find($user_id);

        if($user){
            $result = ['result'=>'1','user'=>$user];
        }else{
            $result = ['result'=>'0'];
        }

        return json_encode($result);
    }


    public function staffRegister(Request $request){
        $vendor_id = $request->route('id');
        $hash = $request->route('hash');
        $hashDecode = Crypt::decryptString($hash);
        $hashArray = json_decode($hashDecode,1);
        $time = $hashArray['D'];
        $email = $hashArray['E'];
        $user = User::where('email',$email)->exists();
        if($user){
            return redirect(route('admin-login'))->with('Errormessage', '此信箱已經註冊完成!請直接登入!');
        }

        if ( !$hashArray['Flag'] ) {
            return redirect(route('admin-login'))->with('Errormessage', '連結有問題!請確認是否透過正確管道發送邀請信!如沒有問題請重新發送!');
        }

        if ( time() - $time > (86400) ) {
            return redirect(route('admin-login'))->with('Errormessage', '已經註冊信已過期!請重新發送!');
        }

        return view('admin.users.staffRegister',[
            'vendor_id'=>$vendor_id,
            'email'=>$email,
        ]);
    }

    public function staffRegisterAction(Request $request){
        $validator = Validator::make($request->toArray(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|same:second_password',
            'second_password'=>'required',
        ]);
        if($validator->fails()){
            $message = '<ul>';
            foreach ($validator->errors()->all() as $text){
                $message .= '<li>'.$text.'</li>';
            }
            $message .= '</ul>';
            return back()->withInput()->with('error',$message);
        }else{
            $data=[
                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password'=>Hash::make($request->get('password')),
                'status'=>1,
                'phone'=>$request->get('phone'),
            ];
            $user = User::create($data);
            ActionLog::create_log($user,'新增');
            $user->assignRole('staff');

            $vendorStaffData = [
                'vendor_id'=>$request->get('vendor_id'),
                'user_id'=>$user->id,
            ];
            $vendorStaff = VendorStaff::create($vendorStaffData);
            ActionLog::create_log($vendorStaff,'新增');

            return redirect(route('admin.user.index'))->with('message', '帳號已建立!');
        }

    }

}
