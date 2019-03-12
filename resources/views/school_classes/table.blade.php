<table class="table table-responsive" id="schoolClasses-table">
    <thead>
        <tr>
        <th>班级名称</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($schoolClasses as $schoolClass)
        <tr>
            <td>{!! $schoolClass->name !!}</td>
            <td>
                {!! Form::open(['route' => ['schoolClasses.destroy',$school_id,$schoolClass->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('schoolClasses.edit',[$school_id,$schoolClass->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>