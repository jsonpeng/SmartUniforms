@extends('admin.layouts.app')

@section('content')
  <div class="container-fluid" style="padding: 30px 15px;">
        <div class="row">
            <div class="col-sm-3 col-lg-2">
                <ul class="nav nav-pills nav-stacked nav-email">
                    <li class="{{ Request::is('zcjy/cities*') ? 'active' : '' }}">
                        <a href="{!! route('cities.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-user"></i> 地区管理
                        </a>
                    </li>
                    <li class="{{ Request::is('zcjy/freightTems*') ? 'active' : '' }}">
                        <a href="{!! route('freightTems.index') !!}">
                            <span class="badge pull-right"></span>
                            <i class="fa fa-users"></i> 运费模板
                        </a>
                    </li>

                </ul>
            </div>

            <div class="col-sm-9 col-lg-10">
              <section class="content-header">
                  <h1>
                      编辑运费模板
                  </h1>
             </section>
             <div class="content">
                 @include('adminlte-templates::common.errors')
                 <div class="box box-primary form">
                     <div class="box-body">
                         <div class="row">
                             {!! Form::model($freightTem, ['route' => ['freightTems.update', $freightTem->id], 'method' => 'patch']) !!}

                                  @include('admin.freight_tems.fields')

                             {!! Form::close() !!}
                         </div>
                     </div>
                 </div>
             </div>
           </div>
         </div>
       </div>
@endsection

@section('scripts')
@include('admin.freight_tems.partials.js')
@endsection
