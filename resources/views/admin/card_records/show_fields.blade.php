<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $cardRecord->id !!}</p>
</div>

<!-- Card Id Field -->
<div class="form-group">
    {!! Form::label('card_id', 'Card Id:') !!}
    <p>{!! $cardRecord->card_id !!}</p>
</div>

<!-- Content Field -->
<div class="form-group">
    {!! Form::label('content', 'Content:') !!}
    <p>{!! $cardRecord->content !!}</p>
</div>

<!-- Read Time Field -->
<div class="form-group">
    {!! Form::label('read_time', 'Read Time:') !!}
    <p>{!! $cardRecord->read_time !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $cardRecord->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $cardRecord->updated_at !!}</p>
</div>

