<!-- Machine Id Field -->
<div class="form-group col-sm-8">
    {!! Form::label('machine_id', '机器ID:') !!}
    {!! Form::text('machine_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Machine Name Field -->
<div class="form-group col-sm-8">
    {!! Form::label('machine_name', '机器名称:') !!}
    {!! Form::text('machine_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('machineIdes.index') !!}" class="btn btn-default">返回</a>
</div>
