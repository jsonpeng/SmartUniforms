<table class="table table-responsive" id="machineIdes-table">
    <thead>
        <tr>
        <th>机器ID</th>
        <th>机器名称</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($machineIdes as $machineIde)
        <tr>
            <td>{!! $machineIde->machine_id !!}</td>
            <td>{!! $machineIde->machine_name !!}</td>
            <td>
                {!! Form::open(['route' => ['machineIdes.destroy', $machineIde->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                 {{--    <a href="{!! route('machineIdes.show', [$machineIde->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('machineIdes.edit', [$machineIde->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>