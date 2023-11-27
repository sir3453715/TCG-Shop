@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">店家管理</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.vendor.index')}}">店家</a></li>
                        <li class="breadcrumb-item active">修改店家</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.vendor.update',['vendor'=>$vendor->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">店家資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-6">
                                                <label class="field-name" for="name">店家名稱</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="店家名稱" value="{{$vendor->name}}" >
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="field-name" for="user_id">店家管理員帳號</label>
                                                <select name="user_id" class="form-control search-user" data-placeholder="Search email" data-roles="vendor" {!! ($html->hasRoles('administrator|manager'))?'':'disabled' !!}>
                                                    <option value="{{$vendor->user_id}}">{{ $vendor->user->name }} - {{$vendor->user->email}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">我的店員</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-group col-12 row">
                                            <div class="form-group col-4">
                                                <input type="hidden" class="form-control" name="vendor_id" id="vendor_id" value="{{$vendor->id}}">
                                                <div class="input-group mb-3">
                                                    <input type="email" class="form-control" name="invite" id="invite" placeholder="請輸入信箱來發送邀請信" value="">
                                                    <span class="input-group-append">
                                                        <button class="btn btn-primary" id="sendInvite" type="button">發送邀請</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <table class="table-default table table-bordered w-100">
                                                <thead>
                                                <tr>
                                                    <th>店員名稱</th>
                                                    <th>電子信箱</th>
                                                    <th>動作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($vendor->vendorStaff as $staff )
                                                    <tr>
                                                        <td>
                                                            {{$staff->user->name}}
                                                        </td>
                                                        <td>
                                                            {{$staff->user->email}}
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-danger delete-staff" data-id="{{$staff->id}}"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-3">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">動作</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-12 row">
                                    <div class="form-group col-12">
                                        <label class="field-name" for="status">狀態</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" {!! $html->selectSelected(1,$vendor->status) !!}>上架</option>
                                            <option value="0" {!! $html->selectSelected(0,$vendor->status) !!}>下架</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="submit_btn btn btn-info" >送出</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection

@push('admin-app-scripts')

    <script type="text/javascript">

        $('body').on('click','#sendInvite',function (e){
            $.ajax({
                type: "POST",
                url:window.location.origin+"/inviteStaff",
                dataType:"json",
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'invite': $('#invite').val(),
                    'vendor_id': $('#vendor_id').val(),
                },
                success:function(object){
                    if(object.result === '1' ) {
                        alert(object.alertMessage );
                        location.reload();
                    }
                }
            });
        });

        $('body').on('click','.delete-staff',function (e){
            e.preventDefault();
            let code = '';
            var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            for (var x = 0; x < 10; x++) {
                var i = Math.floor(Math.random() * chars.length);
                code += chars.charAt(i);
            }
            if(prompt('注意！目前將刪除所選擇項目，此操作無法回覆。 如果仍要繼續動作，請輸入以下代碼： ' + code ) === code) {
                $.ajax({
                    type: "POST",
                    url:window.location.origin+"/deleteStaff",
                    dataType:"json",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'id': $(this).data('id'),
                    },
                    success:function(object){
                        if(object.result === '1' ) {
                            alert(object.alertMessage );
                            location.reload();
                        }
                    }
                });
            }
        });



    </script>



@endpush
