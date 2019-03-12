@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            添加机器
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'machineIdes.store']) !!}

                        @include('admin.machine_ides.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
