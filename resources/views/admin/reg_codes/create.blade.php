@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           添加激活码
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'regCodes.store']) !!}

                        @include('admin.reg_codes.fields',['code'=>$code])

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
