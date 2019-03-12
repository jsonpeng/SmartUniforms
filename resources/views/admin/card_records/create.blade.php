@extends('admin.layouts.app_shop')

@section('content')
    <section class="content-header">
        <h1>
            Card Record
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'cardRecords.store']) !!}

                        @include('admin.card_records.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
