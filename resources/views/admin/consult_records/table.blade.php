<table class="table table-responsive" id="consultRecords-table">
    <thead>
        <tr>
        <th>学校</th>
        <th>类型</th>
        <th>微信用户头像</th>
        <th>微信昵称</th>
        <th>姓名</th>
        <th>性别</th>
        <th>班级</th>
        <th>身高</th>
        <th>体重</th>
        <th>是否处理</th>
        <th>填表时间</th>
    {{--     <th>尺码</th>
        <th>规格</th> --}}
   
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($consultRecords as $consultRecord)
    <?php $user=$consultRecord->user()->first();?>
        <tr>
            <td>{!! $consultRecord->school_name !!}</td>
            <td>{!! $consultRecord->type !!}</td>
            <td><img src="{!! $user->head_image !!}" style="max-width: 100%;height: 80px;" /></td>
            <td>{!! $user->nickname !!}</td>
            <td>{!! $consultRecord->name !!}</td>
            <td>{!! $consultRecord->sex !!}</td>
            <td>{!! $consultRecord->class !!}</td>
            <td>{!! $consultRecord->shengao !!}</td>
            <td>{!! $consultRecord->tizhong !!}</td>
            <td>{!! $consultRecord->do ? '已处理':'未处理' !!}</td>
            <td>{!! $consultRecord->created_at !!}</td>
  {{--           <td>{!! $consultRecord->chima !!}</td>
            <td>{!! $consultRecord->guige !!}</td> --}}
          
            <td>
                {!! Form::open(['route' => ['consultRecords.destroy', $consultRecord->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('consultRecords.show', [$consultRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('consultRecords.edit', [$consultRecord->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>