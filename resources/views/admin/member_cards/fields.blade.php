<!-- Register Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('register_type', 'Register Type:') !!}
    {!! Form::text('register_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Code:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- Openid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('openid', 'Openid:') !!}
    {!! Form::text('openid', null, ['class' => 'form-control']) !!}
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mobile', 'Mobile:') !!}
    {!! Form::text('mobile', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('memberCards.index') !!}" class="btn btn-default">Cancel</a>
</div>
