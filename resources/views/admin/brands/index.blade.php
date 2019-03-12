@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header mb10-xs">
        <h1 class="pull-left">品牌列表</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-bottom: 5px" href="{!! route('brands.create') !!}">添加</a>
        </h1>
    </section>
    <div class="content pdall0-xs">
        <div class="clearfix"></div>

        @include('admin.partials.message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin.brands.table')
            </div>
        </div>
          <div class="tc"><?php echo $brands->appends('')->render(); ?></div>
    </div>
@endsection

