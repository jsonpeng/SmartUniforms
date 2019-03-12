<table class="table table-responsive" id="cardLogs-table">
    <thead>
        <tr>
            <th>Shopinfo</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cardLogs as $cardLog)
        <tr>
            <td>{!! $cardLog->shopinfo !!}</td>
            <td>
                {!! Form::open(['route' => ['cardLogs.destroy', $cardLog->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('cardLogs.show', [$cardLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('cardLogs.edit', [$cardLog->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>