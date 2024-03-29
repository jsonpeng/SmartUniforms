<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', '等级名称:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('amount', '消费金额:') !!}
    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-12">
    {!! Form::label('discount', '折扣率:') !!}
    {!! Form::number('discount', null, ['class' => 'form-control']) !!}
</div>

<!-- Discribe Field -->
<div class="form-group col-sm-12">
    {!! Form::label('discribe', '描述:') !!}
    {!! Form::text('discribe', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userLevels.index') !!}" class="btn btn-default">取消</a>
</div>
