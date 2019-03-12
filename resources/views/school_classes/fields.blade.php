
{!! Form::hidden('school_id', $school_id , ['class' => 'form-control']) !!}


<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '班级名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('schoolClasses.index',$school_id) !!}" class="btn btn-default">返回</a>
</div>
