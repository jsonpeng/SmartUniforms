<div class="form-group col-sm-8">
    {!! Form::label('school_name', '所在学校:') !!}
    {!! Form::text('school_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', '姓名:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Class Field -->
<div class="form-group col-sm-6">
    {!! Form::label('class', '班级:') !!}
    {!! Form::text('class', null, ['class' => 'form-control']) !!}
</div>

<!-- Shengao Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shengao', '身高:') !!}
    {!! Form::text('shengao', null, ['class' => 'form-control']) !!}
</div>

<!-- Tizhong Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tizhong', '体重:') !!}
    {!! Form::text('tizhong', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('commit', '家长联系方式:') !!}
    {!! Form::text('commit', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-8">
    {!! Form::label('created_at', '加入时间:') !!}
    {!! Form::text('created_at', null, ['class' => 'form-control','readonly'=>'true']) !!}
</div>

{{-- 
<div class="form-group col-sm-8">
    {!! Form::label('guige', '规格:') !!}
    {!! Form::text('guige', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Remark Field -->
<div class="form-group col-sm-8">
    {!! Form::label('remark', '备注:') !!}
    {!! Form::textarea('remark', null, ['class' => 'form-control']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    @if(isset($consultRecord) && $consultRecord->do == 0) 
        {!! Form::button('处理完成', ['class' => 'btn btn-success','onclick'=>'$(".dealForm").submit()']) !!} 
    @else
        {!! Form::button('已处理', ['class' => 'btn btn-default','onclick'=>'$(".dealForm").submit()']) !!} 
    @endif
    <a href="{!! route('consultRecords.index') !!}" class="btn btn-default">返回</a>
</div>



