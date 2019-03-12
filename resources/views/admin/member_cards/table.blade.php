<table class="table table-responsive" id="memberCards-table">
    <thead>
        <tr>
            <th>激活方式</th>
            <th>激活码</th>
        {{--     <th>用户OPENID</th> --}}
            <th>手机</th>
            <th>激活时间</th>
            <th>是否通知</th>
        </tr>
    </thead>
    <tbody>
    @foreach($memberCards as $memberCard)
        <tr>
            <td>{!! $memberCard->register_type !!}</td>
            <td>{!! $memberCard->code !!}</td>
           {{--  <td>{!! $memberCard->openid !!}</td> --}}
            <td>{!! $memberCard->mobile !!}</td>
            <td>{!! $memberCard->created_at !!}</td>
            <td>{!! $memberCard->status==0 ? '否' : '是' !!} </td>
            <td>
                {!! Form::open(['route' => ['memberCards.destroy', $memberCard->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('memberCards.show', [$memberCard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('memberCards.edit', [$memberCard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>