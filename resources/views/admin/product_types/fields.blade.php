<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '类型名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('productTypes.index') !!}" class="btn btn-default">取消</a>
</div>