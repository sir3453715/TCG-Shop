@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">主控台</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">登入紀錄(僅顯示前25筆)</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table-default table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>登入IP</th>
                                <th>結果</th>
                                <th>時間</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($login_log as $login)
                                <tr>
                                    <td>
                                        @if($login->user)
                                            <a href="{{route('admin.user.edit',['user'=>$login->user->id])}}" target="_blank">
                                                {{$login->user->name}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{$login->IP}}</td>
                                    <td>{{$login->result}}</td>
                                    <td>{{$login->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>

{{--    <form id="edit-order-form" class="edit-order-form" action="{{ route('admin.card.rarity')}}" method="post" enctype="multipart/form-data">--}}
{{--        @csrf--}}
{{--        @method('POST')--}}
{{--        <input type="file" name="import" id="import">--}}
{{--        <button type="submit">送出</button>--}}
{{--    </form>--}}
@endsection

@push('admin-app-scripts')
    <script type="text/javascript">
    </script>
@endpush
