<table class="table table-responsive" id="cardRecords-table">
    <thead>
        <tr>
        <th>读卡器ID</th>
        <th>是否短信通知</th>
        <th>位置信息</th>
        <th>别名(可自定义)</th>
        <th>读取到的时间</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($cardRecords as $cardRecord)
        <tr>
            <td>{!! $cardRecord->card_id !!}</td>
            <td>{!! empty($cardRecord->code) ? '否' : '是' !!}</td>
            <td>{!! $cardRecord->location !!}</td>
            <td>{!! $cardRecord->remark !!}</td>
            <td>{!! empty($cardRecord->read_time)?$cardRecord->created_at:$cardRecord->read_time !!}</td>
            <td>
            
                <div class='btn-group'>
                  {{--   <a href="{!! route('cardRecords.show', [$cardRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                        {!! Form::open(['route' => ['cardRecord.report', $cardRecord->id],'style'=>'display:inline;']) !!}
                                <button type="submit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-download-alt" title="导出"></i></button>
                        {!! Form::close() !!}
                    <a href="{!! route('cardRecords.edit', [$cardRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::open(['route' => ['cardRecords.destroy', $cardRecord->id], 'method' => 'delete']) !!}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认要删除吗?')"]) !!}
                       {!! Form::close() !!}
                </div>
             
            </td>
        </tr>
    @endforeach
    </tbody>
</table>