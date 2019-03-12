<!-- Consult Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('consult_id', 'Consult Id:') !!}
    {!! Form::text('consult_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Chima Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chima', 'Chima:') !!}
    {!! Form::text('chima', null, ['class' => 'form-control']) !!}
</div>

<!-- Zengding Field -->
<div class="form-group col-sm-6">
    {!! Form::label('zengding', 'Zengding:') !!}
    {!! Form::text('zengding', null, ['class' => 'form-control']) !!}
</div>

<!-- Tuihui Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tuihui', 'Tuihui:') !!}
    {!! Form::text('tuihui', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('attachConsults.index') !!}" class="btn btn-default">Cancel</a>
</div>
