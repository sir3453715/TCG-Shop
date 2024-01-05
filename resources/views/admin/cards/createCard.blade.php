@extends('admin.layouts.app')

{{--@section('title', 'System Status')--}}

@section('admin-page-content')
    @inject('html', 'App\Presenters\Html\HtmlPresenter')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">新增卡牌</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('admin.card.index')}}">卡牌管理</a></li>
                        <li class="breadcrumb-item active">新增卡牌</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <form id="create-Form" class="create-Form" action="{{ route('admin.card.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">卡牌資料</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">

                                    <div class="col-12 col-md-4 row">
                                        <div class="col-6 col-md-12">
                                            <label class="field-name" for="image">卡牌圖片</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>
                                        <div class="col-6 col-md-12">
                                            <img id="cardUploadImg" class="w-100 p-3" src="/storage/image/Admin/UploadImgBackground.webp">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8">
                                        <div class="col-md-12 row">
                                            <div class="form-group col-6 col-md-3">
                                                <label class="field-name" for="series">系列名稱</label>
                                                <select class="form-control" name="series_id" id="series_id">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($seriess as $series)
                                                        <option value="{{$series->id}}" >{{$series->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-3">
                                                <label class="field-name" for="serial_code">系列編號</label>
                                                <input type="text" class="form-control" name="serial_code" id="serial_code" placeholder="系列編號">
                                            </div>
                                            <div class="form-group col-6 col-md-3">
                                                <label class="field-name" for="serial_number">系列編號</label>
                                                <input type="text" class="form-control" name="serial_number" id="serial_number" placeholder="系列編號">
                                            </div>
                                            <div class="form-group col-6 col-md-3">
                                                <label class="field-name" for="type">卡牌類型</label>
                                                <select class="form-control" name="type" id="type">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($types as $type)
                                                        <option value="{{$type}}" >{{$type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="attribute">屬性</label>
                                                <select class="form-control" name="attribute" id="attribute">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($attributes as $attribute)
                                                        <option value="{{ $attribute }}">{{ $attribute }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="name">卡牌名稱</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="卡牌名稱">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="hp">卡牌生命(血量)</label>
                                                <input type="text" class="form-control" name="hp" id="hp" placeholder="卡牌生命(血量)">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <label class="field-name" for="weakpoint">弱點</label>
                                                        <select class="form-control" name="weakpoint" id="weakpoint">
                                                            <option value="" hidden>請選擇</option>
                                                            @foreach($attributes as $attribute)
                                                                <option value="{{ $attribute }}">{{ $attribute }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-7">
                                                        <label class="field-name" for="weakpoint_value">數值</label>
                                                        <input type="text" class="form-control" name="weakpoint_value" id="weakpoint_value">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <label class="field-name" for="resist">抵抗力</label>
                                                        <select class="form-control" name="resist" id="resist">
                                                            <option value="" hidden>請選擇</option>
                                                            @foreach($attributes as $attribute)
                                                                <option value="{{ $attribute }}">{{ $attribute }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-7">
                                                        <label class="field-name" for="resist_value">數值</label>
                                                        <input type="text" class="form-control" name="resist_value" id="resist_value">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="escape">撤退</label>
                                                <input type="text" class="form-control" name="escape" id="escape">
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="competition_number">賽制編號</label>
                                                <select class="form-control" name="competition_number" id="competition_number">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($competitions as $competition)
                                                        <option value="{{ $competition }}">{{ $competition }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="rarity">稀有度</label>
                                                <select class="form-control" name="rarity" id="rarity">
                                                    <option value="" hidden>請選擇</option>
                                                    @foreach($rarities as $rarity)
                                                        <option value="{{ $rarity }}">{{ $rarity }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-6 col-md-4">
                                                <label class="field-name" for="default_price">預設金額</label>
                                                <input type="text" class="form-control" name="default_price" id="default_price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group col-12">
                                            <label class="field-name" for="skill">技能說明</label>
                                            <button class="btn btn-sm btn-outline-primary" id="add-skill" type="button">+ 新增技能</button>
                                            <table class="table-default table table-bordered w-100">
                                                <thead>
                                                    <tr>
                                                        <th>技能名稱</th>
                                                        <th>屬性</th>
                                                        <th>技能說明</th>
                                                        <th>數值</th>
                                                        <th>動作</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="skill-tbody">
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="skill_name" name="skill_name[]" value="">
                                                        </td>
                                                        <td class="skill-attr-td">
                                                            <div class="row">
                                                                <select class="form-control skill_attribute_select col-3">
                                                                    <option value="" hidden>請選擇</option>
                                                                    @foreach($attributes as $attribute)
                                                                        <option value="{{ $attribute }}">{{ $attribute }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="text" class="form-control skill_attribute col-9" name="skill_attribute[]" id="skill_attribute">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="skill_desc" name="skill_desc[]" value="">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="skill_damage" name="skill_damage[]" value="" >
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-danger skill-clear"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
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
                                        <label class="field-name" for="kingdom">卡牌領域</label>
                                        <select class="form-control" name="kingdom" id="kingdom">
                                            <option value="" hidden>請選擇</option>
                                            @foreach($kingdoms as $key => $kingdom)
                                                <option value="{{$key}}" >{{$kingdom}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="field-name" for="lang">卡牌語系</label>
                                        <select class="form-control" name="lang" id="lang">
                                            <option value="" hidden>請選擇</option>
                                            <option value="tw" >中文</option>
                                            <option value="en" >英文</option>
                                            <option value="jp" >日文</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="field-name" for="tw_id">主語系編號(台灣卡)</label>
                                        <input type="text" class="form-control" name="tw_id" id="tw_id" placeholder="主語系編號">
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

        $("body").on('click','#add-skill',function (){
            let trHTML = $('#skill-tr-html').html();
            $('#skill-tbody').append(trHTML);
        });
        $("body").on('click','.skill-clear',function (){
            let tr = $(this).closest('tr');
            tr.remove();
        });

        $("body").on('change','.skill_attribute_select',function () {
            let selectValue = $(this).val(), skill_attribute = $(this).siblings('.skill_attribute');
            if(skill_attribute.val() === ''){
                skill_attribute.val(selectValue);
            }else{
                skill_attribute.val(skill_attribute.val()+','+selectValue);
            }
            $(this).val('');
        });
    </script>


    <script type="text/html" id="skill-tr-html">
        <tr>
            <td><input type="text" class="form-control" id="skill_name" name="skill_name[]" value=""></td>
            <td class="skill-attr-td">
                <div class="row">
                    <select class="form-control skill_attribute_select col-3">
                        <option value="" hidden>請選擇</option>
                        @foreach($attributes as $attribute)
                            <option value="{{ $attribute }}">{{ $attribute }}</option>
                        @endforeach
                    </select>
                    <input type="text" class="form-control skill_attribute col-9" name="skill_attribute[]" id="skill_attribute">
                </div>
            </td>
            <td><input type="text" class="form-control" id="skill_desc" name="skill_desc[]" value=""></td>
            <td><input type="text" class="form-control" id="skill_damage" name="skill_damage[]" value="" ></td>
            <td><button type="button" class="btn btn-sm btn-danger skill-clear"><i class="fa fa-trash"></i></button></td>
        </tr>
    </script>
@endpush
