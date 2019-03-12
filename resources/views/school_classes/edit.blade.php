@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           编辑
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($schoolClass, ['route' => ['schoolClasses.update', $school_id,$schoolClass->id], 'method' => 'patch']) !!}

                        @include('school_classes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection