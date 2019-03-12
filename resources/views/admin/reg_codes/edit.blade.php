@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑激活码
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($regCode, ['route' => ['regCodes.update', $regCode->id], 'method' => 'patch']) !!}

                        @include('admin.reg_codes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection