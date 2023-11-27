<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailQueueJob;
use App\Models\ActionLog;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;

class VendorsController extends Controller
{
    /**
     * index
     */
    function index(Request $request){

        $user = Auth::user();
        if(Auth::user()->hasRole('vendor')){
            return redirect(route('admin.vendor.edit',['vendor'=>$user->vendor->id]));
        }

        $queried = ['keyword'=>'','status'=>''];
        $vendors = Vendor::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $vendors = $vendors->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('status')) {
            $status = $request->get('status');
            $vendors = $vendors->where('status',$status);
            $queried['status'] = $status;
        }

        $vendors = $vendors->orderBy('created_at','ASC')->paginate(25);

        return view('admin.vendors.vendors',[
            'queried'=>$queried,
            'vendors'=>$vendors,
        ]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.vendors.createVendor');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=[
            'name'=>$request->get('name'),
            'user_id'=>$request->get('user_id'),
            'status'=>$request->get('status'),
        ];

        $vendor = Vendor::create($data);

        ActionLog::create_log($vendor,'新增');

        return redirect(route('admin.vendor.index'))->with('message', '店家已新增!');

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
        $vendor = Vendor::find($id);

        return view('admin.vendors.editVendor',[
            'vendor'=>$vendor,
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

        $vendor = Vendor::find($id);

        $data=[
            'name'=>$request->get('name'),
            'status'=>$request->get('status'),
        ];
        if($request->get('user_id')){
            $data['user_id']=$request->get('user_id');
        }
        dd($data);

        $vendor = $vendor->fill($data);
        ActionLog::create_log($vendor);
        $vendor->save();

        return redirect(route('admin.vendor.index'))->with('message', '店家已修改!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);


        $vendor->delete();
        ActionLog::create_log($vendor,'刪除');

        return redirect(route('admin.vendor.index'))->with('message', '店家已刪除!');
    }

    public function inviteStaff(Request $request)
    {
        $vendor_id = $request->get('vendor_id');
        $vendor = Vendor::find($vendor_id);

        $email = $request->get('invite');
        $inviteUserRegister = User::where('email',$email)->exists();
        if($inviteUserRegister ){
            if($inviteUserRegister->hasRole('customer')){
                $inviteUserRegister->assignRole('staff');
                $vendorStaffData = [
                    'vendor_id'=>$vendor_id,
                    'user_id'=>$inviteUserRegister->id,
                ];
                $vendorStaff = VendorStaff::create($vendorStaffData);
                ActionLog::create_log($vendorStaff,'新增');
                return json_encode(['result'=>'1','alertMessage'=>'已將帳號加入到店員列表中']);
            }else{
                return json_encode(['result'=>'1','alertMessage'=>'此帳號無法加入至店員列表中!']);
            }
        }else{
            $staffRegisterURL = route('staffRegister',[
                    'id' => $vendor_id,
                    'hash' => Crypt::encryptString(json_encode(['E'=>$email,'V'=>$vendor_id,'D'=>time(),'Flag'=>true])),
                ]);

            $data = [
                'email'=>$email,
                'subject'=>$vendor->name.'邀請您加入TCG SHOP',
                'for_title'=>'',
                'msg'=>$vendor->name.'邀請您加入TCG SHOP，請透過下方連結完成註冊手續。<br/>'
                        .'<a href="'.$staffRegisterURL.'">註冊連結</a>',
            ];
            dispatch(new SendMailQueueJob($data));

            return json_encode(['result'=>'1','alertMessage'=>'已發送邀請信至該信箱!']);
        }

    }
    public function deleteStaff(Request $request){
        $vendorStaff = VendorStaff::find($request->get('id'));
        if($vendorStaff){
            $vendorStaff->delete();
            ActionLog::create_log($vendorStaff,'刪除');
        }

        return json_encode(['result'=>'1','alertMessage'=>'已刪除該員工!']);

    }
}
