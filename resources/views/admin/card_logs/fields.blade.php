<!-- Shopinfo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('shopinfo', 'Shopinfo:') !!}
    {!! Form::text('shopinfo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('cardLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
