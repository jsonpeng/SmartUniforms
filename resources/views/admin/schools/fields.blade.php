<!-- Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('name', '学校名称(必填):') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-8">
    {!! Form::label('number', '学校编号(可不填):') !!}
    {!! Form::text('number', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('schools.index') !!}" class="btn btn-default">返回</a>
</div>
