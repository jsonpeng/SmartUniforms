@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">征询单列表</h1>
        <a href="javascript:$('.guige_form').submit();">导出全部规格汇总</a>
        <a href="javascript:$('.zhengding_form').submit();">导出全部征订详情</a>
     {{--    <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('consultRecords.create') !!}">Add New</a>
        </h1> --}}
        {!! Form::open(['route' => ['products.exportS'], 'method' => 'post','class'=>'guige_form']) !!}

        {!! Form::close() !!}

        {!! Form::open(['route' => ['products.exportC'], 'method' => 'post','class'=>'zhengding_form']) !!}

        {!! Form::close() !!}
    </section>
    <div class="content pdall0-xs">
              <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs @if(!$tools) collapsed-box @endif">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="order_search">

                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="product_id_sort">所在学校</label>
                        <select class="form-control" name="schools_name">
                            <option value="" @if (!array_key_exists('schools_name', $input)) selected="selected" @endif>全部</option>
                            @if(count($schools))
                                @foreach($schools as $school)
                                    <option value="{!! $school->name !!}" @if (array_key_exists('schools_name', $input) && $input['schools_name'] == $school->name ) selected="selected" @endif>{!! $school->name !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div> 

                       <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="product_id_sort">类型</label>
                        <select class="form-control" name="type">
                            <option value="" @if (!array_key_exists('type', $input)) selected="selected" @endif>全部</option>
                            <option value="征订单" @if (array_key_exists('type', $input) && $input['type'] == '征订单') selected="selected" @endif>征订单</option>
                             <option value="调换单" @if (array_key_exists('type', $input) && $input['type'] == '调换单') selected="selected" @endif>调换单</option>
                        </select>
                    </div> 
                    
                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <label for="order_delivery">班级</label>
                       <input type="text" class="form-control" name="class" placeholder="班级" @if (array_key_exists('class', $input))value="{{$input['class']}}"@endif>
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-12 col-xs-12">
                        <label for="order_delivery">学生姓名</label>
                       <input type="text" class="form-control" name="name" placeholder="学生姓名" @if (array_key_exists('name', $input))value="{{$input['name']}}"@endif>
                    </div>
      
                    <div class="form-group col-lg-1 col-md-1 hidden-xs hidden-sm" style="padding-top: 25px;">
                        <button type="submit" class="btn btn-primary pull-right " onclick="search()">查询</button>
                    </div>
                    <div class="form-group col-xs-6 visible-xs visible-sm" >
                        <button type="submit" class="btn btn-primary pull-left " onclick="search()">查询</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.consult_records.table')
            </div>
        </div>
        <div class="text-center">
            {!! $consultRecords->appends($input)->links() !!}
        </div>
    </div>
@endsection

