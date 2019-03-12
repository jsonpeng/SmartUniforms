@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Member Card
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($memberCard, ['route' => ['memberCards.update', $memberCard->id], 'method' => 'patch']) !!}

                        @include('admin.member_cards.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection