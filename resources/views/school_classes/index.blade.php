@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">管理{!! $school->name !!}的班级</h1><a href="/zcjy/schools">返回上一级</a>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('schoolClasses.create',$school_id) !!}">添加</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('school_classes.table')
            </div>
        </div>
        <div class="text-center">
            {!! $schoolClasses->appends('')->links() !!}
        </div>
    </div>
@endsection

