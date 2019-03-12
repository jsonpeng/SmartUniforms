<table class="table table-responsive" id="regCodes-table">
    <thead>
        <tr>
        <th>激活码</th>
        <th>使用状态</th>
        <th>价格</th>
        <th>激活码别名</th>
        <th>短信模板</th>
        <th>操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($regCodes as $regCode)

        <tr>
            <td>{!! $regCode->code !!}</td>
            <td>{!! $regCode->UseState !!}</td>
            <td>{!! $regCode->price !!}</td>
            <td>{!! $regCode->name !!}</td>
            <td>{!! empty($regCode->template) ? '默认' : '备选'!!}</td>
            <td>
               
                <div class='btn-group'>
                    <a href="{!! route('regCodes.edit', [$regCode->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                </div>
               
            </td>
        </tr>
    @endforeach
    </tbody>
</table>