@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            编辑查看
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => ['consultRecords.dealForm', $consultRecord->id], 'method' => 'post','class'=>'dealForm']) !!}
        {!! Form::close() !!}

        {!! Form::model($consultRecord, ['route' => ['consultRecords.update', $consultRecord->id], 'method' => 'patch']) !!}
       <div class="box box-primary">

           <div class="box-body">
               <div class="row">
                  

                        @include('admin.consult_records.fields')

                 
               </div>
                <?php $all_price = 0;?>
                @foreach($records as $record)

                    <?php $all_price += $record->price*$record->zengding; ?>

                @endforeach

               <h4>征订退回校服<span style="color: red;">[总价:{!! $all_price !!}]</span></h4>

               @if(isset($consultRecord))

                  <table class="table table-responsive" id="consultRecords-table">
                      <thead>
                          <tr>
                          <th>校服名称</th>
                          <th>尺码</th>
           {{--                <th>价格</th> --}}
                          <th>征订数量</th>
                          <th>退回数量</th>
                      {{--     <th>尺码</th>
                          <th>规格</th> --}}
                     
                          <th colspan="3">操作</th>
                          </tr>
                      </thead>
                      <tbody>
                      @foreach($records as $consultRecord)
                          <tr>
                              <td>{!! $consultRecord->pname !!}<input type="hidden" name="pname[]" value="{!! $consultRecord->pname !!}" /></td>
                              <td>{!! $consultRecord->chima !!}<input type="hidden" name="chima[]" value="{!! $consultRecord->chima !!}" /></td>
                              <input type="hidden" name="price[]" value="{!! $consultRecord->price !!}" />
                              <td><input type="number" name="zengding[]" value="{!! $consultRecord->zengding !!}" /></td>
                                <td><input type="number" name="tuihui[]" value="{!! $consultRecord->tuihui !!}" /></td>
                    {{--           <td>{!! $consultRecord->chima !!}</td>
                              <td>{!! $consultRecord->guige !!}</td> --}}
                            
                              <td>
                               
                                  <div class='btn-group'>
                                  {{--     <a href="{!! route('consultRecords.show', [$consultRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                                  
                                      {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "$(this).parent().parent().parent().remove();"]) !!}
                                  </div>
                             
                              </td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>

               @endif


           </div>
       </div>
         {!! Form::close() !!}
   </div>
@endsection