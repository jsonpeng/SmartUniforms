@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">激活记录</h1><a href="/zcjy/all_del/memberCards">全部删除</a>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="box box-default box-solid mb10-xs @if(!$tools) collapsed-box @endif">
            <div class="box-header with-border">
              <h3 class="box-title">查询</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-{!! !$tools?'plus':'minus' !!}"></i></button>
              </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="code_search">
                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="status">是否通知</label>
                        <select class="form-control" name="status">
                            <option value="-1" @if (!array_key_exists('status', $input) || $input['status'] == '-1') selected="selected" @endif>全部</option>
                            <option value="1" @if (array_key_exists('status', $input) && $input['status'] == '1') selected="selected" @endif>是</option>
                            <option value="0" @if (array_key_exists('status', $input) && $input['status'] == '0') selected="selected" @endif>否</option>
                        </select> 
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="code">激活码</label>
                        <input class="form-control" name="code" @if (array_key_exists('code', $input)) value="{{$input['code']}}"@endif/>
                    </div>

                    <div class="form-group col-lg-2 col-md-3 col-sm-6 col-xs-6">
                        <label for="mobile">手机</label>
                        <input class="form-control" name="mobile" @if (array_key_exists('mobile', $input)) value="{{$input['mobile']}}"@endif/>
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
                    @include('admin.member_cards.table')
            </div>
        </div>
        <div class="tc">{!! $memberCards->appends($input)->links(); !!}</div>
    </div>
@endsection

