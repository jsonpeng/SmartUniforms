@if(empty($regCode))
<!-- Code Field -->
<div class="form-group col-sm-12">
    {!! Form::label('code', '激活码(从'.$code.'起):') !!}
    {!! Form::text('code', $code, ['class' => 'form-control','readonly' => 'readonly']) !!}
</div>
@else
<div class="form-group col-sm-12">
    {!! Form::label('code', '激活码:') !!}
    {!! Form::text('code', null , ['class' => 'form-control','readonly' => 'readonly']) !!}
</div>
@endif

@if(empty($regCode))
<!-- Status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('num', '批量添加多少个(自动累增,不填默认添加一个):') !!}
    {!! Form::text('num', null, ['class' => 'form-control','maxlength'=>5]) !!}
</div>
@endif

<div class="form-group col-sm-12">
    {!! Form::label('name', '激活码别名(可自定义不能超出20位):') !!}
    {!! Form::text('name', null, ['class' => 'form-control','maxlength'=>'19']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('price', '激活码价格:') !!}
    {!! Form::text('price', null, ['class' => 'form-control','maxlength'=>8]) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('template', '短信模板:') !!}
    <select class="form-control" name="template">
                <option value="0"   @if(!empty($regCode) && $regCode->template == 0) selected="selected" @endif>默认(亲爱的家长，我们于{time}在{address}发现了您的{product}，请知悉。)</option>
                <option value="1"   @if(!empty($regCode) && $regCode->template == 1) selected="selected" @endif>备选(亲爱的家长，您的{product}于{time}已经安放在{address}，请速领取。)</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('regCodes.index') !!}" class="btn btn-default">返回</a>
</div>
