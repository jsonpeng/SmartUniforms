@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑机器
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($machineIde, ['route' => ['machineIdes.update', $machineIde->id], 'method' => 'patch']) !!}

                        @include('admin.machine_ides.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection