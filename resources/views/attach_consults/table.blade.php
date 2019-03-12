<table class="table table-responsive" id="attachConsults-table">
    <thead>
        <tr>
            <th>Consult Id</th>
        <th>Name</th>
        <th>Chima</th>
        <th>Zengding</th>
        <th>Tuihui</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($attachConsults as $attachConsult)
        <tr>
            <td>{!! $attachConsult->consult_id !!}</td>
            <td>{!! $attachConsult->name !!}</td>
            <td>{!! $attachConsult->chima !!}</td>
            <td>{!! $attachConsult->zengding !!}</td>
            <td>{!! $attachConsult->tuihui !!}</td>
            <td>
                {!! Form::open(['route' => ['attachConsults.destroy', $attachConsult->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('attachConsults.show', [$attachConsult->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('attachConsults.edit', [$attachConsult->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>