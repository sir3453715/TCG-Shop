@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">修改Banner</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.banner.index')}}">Banner設置</a></li>
                        <li class="breadcrumb-item active">修改Banner</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.banner.update',['banner'=>$banner->id]) }}" method="post" enctype="multipart/form-data">
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
                                <h3 class="card-title">Banner資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">

                                    <div class="col-12 col-md-4 row">
                                        <div class="col-12">
                                            <label class="field-name" for="image">Banner圖片</label>
                                            <input type="file" class="form-control-file" name="image" id="image">
                                        </div>
                                        <div class="col-12">
                                            <img id="cardUploadImg" class="w-100 p-3" src="{{$banner->image}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-12 col-md-6">
                                                <label class="field-name" for="title">標題</label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Banner標題" value="{{$banner->title}}">
                                            </div>
                                            <div class="form-group col-12 col-md-6">
                                                <label class="field-name" for="link">連結</label>
                                                <input type="text" class="form-control" name="link" id="link" placeholder="Banner連結" value="{{$banner->link}}">
                                            </div>
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
                                    <div class="form-group col-6">
                                        <label class="field-name" for="status">Banner狀態</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" {!! $html->selectSelected(1,$banner->status) !!}>上架</option>
                                            <option value="0" {!! $html->selectSelected(0,$banner->status) !!}>下架</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label class="field-name" for="sort">排序</label>
                                        <input type="text" class="form-control" name="sort" id="sort" value="{{$banner->sort}}">
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

        $("body").on('click','#cardUploadImg',function () {
            $('#image').click();
        });
        $(document.body).on('change', 'input[type=file]', e => {
            let reader = new FileReader(),
                $this = $(e.currentTarget),
                $preview = $('#cardUploadImg');

            if(!$this.val()) return;
            if($preview.length) {
                reader.onload = function(_e) {
                    $preview.attr('src',_e.target.result);
                }
                reader.readAsDataURL(e.currentTarget.files[0]);

            }
        });

    </script>


@endpush
