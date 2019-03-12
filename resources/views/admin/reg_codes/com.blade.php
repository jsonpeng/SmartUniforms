@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           统一设置激活码价格
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'regCode.com', 'method' => 'post']) !!}
                        <div class="form-group col-sm-8">
                            {!! Form::label('price', '请输入统一激活码价格:') !!}
                            {!! Form::text('price', null, ['class' => 'form-control','maxlength'=>8]) !!}
                        </div>
                        <div class="form-group col-sm-12">
                            {!! Form::submit('设置', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('regCodes.index') !!}" class="btn btn-default">返回</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
