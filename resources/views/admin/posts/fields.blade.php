<!-- Name Field -->
<div class="form-group col-sm-8">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">文章正文</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="form-group">
                @if(array_key_exists('post_type', $input))
                {!! Form::hidden('type',$input['post_type'], ['class' => 'form-control','id'=>'post']) !!}
                @else
                {!! Form::hidden('type','post', ['class' => 'form-control','id'=>'post']) !!}
                @endif
                {!! Form::label('name', '标题(必填):') !!}
                {!! Form::text('name', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('slug', '别名:') !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group" style="overflow: hidden;">
                @foreach ($categories as $category)
                <div style="float: left; margin-right: 20px; ">
                    <label>
                        {!! Form::checkbox('categories[]', $category->id, in_array($category->id, $selectedCategories), ['class' => 'select_cat','data-slug'=>$category->slug]) !!}
                            {!! $category->name !!}
                    </label>
                </br>
            </div>
            @endforeach
        </div>

        <div class="form-group">
            {!! Form::label('brief', '简介:') !!}
                {!! Form::textarea('brief', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('brief', '标题/简介颜色(请根据特色图片背景选择合适颜色):') !!}
            <select class="form-control" name="title_color">
                    <option value="0" @if(isset($post) && $post->title_color == '0') selected="selected" @endif>默认</option>
                    <option value="1" @if(isset($post) && $post->title_color == '1') selected="selected" @endif>白色</option>
            </select>
        </div>

        <div class="form-group">
            {!! Form::label('content', '正文(必填):') !!}
                {!! Form::textarea('content', null, ['class' => 'form-control intro']) !!}
        </div>
    </div>
    <!-- /.box-body -->
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-4">

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">发布设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            <label class="fb">
                {!! Form::checkbox('status', 1, null, ['class' => 'field minimal']) !!}发布
            </label>
        </div>
        {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('posts.index') !!}" class="btn btn-default">取消</a>
    </div>
    <!-- /.box-body -->
</div>

<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">其他设置</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('image', '特色图片:') !!}
            <div class="input-append">
                {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image')">选择图片</a>
                <img src="@if($post) {{$post->
                image}} @endif" style="max-width: 100%; max-height: 150px; display: block;">
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('view', '浏览量:') !!}
                {!! Form::number('view', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('sort', '排序:') !!}
                {!! Form::number('sort', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- /.box-body -->
</div>

<!--编辑文本时-->
@if(array_key_exists('post_type', $input))
<div class="box box-solid" id="{!! $attach->
    slug !!}">
    <div class="box-header with-border">
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down" data-function="switch-table" data-type="team-table"></a>
        </span>
        <h3 class="box-title">自定义字段</h3>
        <p class="text-muted">
            为 <strong style="color:black;">{!! $attach->name !!}</strong>
            单独扩充的字段
        </p>
    </div>
    <!-- /.box-header -->
    <div class="box-body" id="team-table" data-status="show">
        <?php $e=11;?>
        @foreach($attach_items as $item)
        <div class="form-group">
            <div class="form-group">
                {!! Form::label($item->key, $item->name) !!}
                <?php $type=$item->
                findType;?>

                @if($type=='image')
                <?php $e++;?>
                <div class="input-append">
                    {!! Form::text($item->key.'[]',$item->value, ['class' => 'form-control','id'=>'image'.$e]) !!}
                    <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image{!! $e !!}')">选择图片</a>
                    <img src="{!! $item->
                    value !!}" style="max-width: 100%; max-height: 150px; display: block;">
                </div>
                @elseif($type=='select')
                <select class="form-control"  name="{!! $item->
                    key.'[]' !!}" >
                    <?php $list_select_create=explode(',',$item->
                    ItemsValue);?>
                   @foreach($list_select_create as $items)
                    <option  value="{!! $items !!}" {!! $item->value==$items?'selected':'' !!}>{!! $items !!}</option>
                    @endforeach
                </select>
                @elseif($type=='checkbox')
                <?php $list_select_create=explode(',',$item->
                ItemsValue);?>
                 @foreach($list_select_create as $items)
                <label class="fb">
                    {!! Form::checkbox($item->key.'[]',$items,in_array($items,[$item->value]), ['class' => 'custom_checkbox']) !!} {!! $items !!}
                </label>
                @endforeach
                @elseif($type=='longText')
                {!! Form::textarea($item->key.'[]', $item->value, ['class' => 'form-control intro']) !!}
                @elseif($type=='textarea')
                {!! Form::textarea($item->key.'[]', str_replace("
                <br/>
                ", "\n", $item->value), ['class' => 'form-control','rows'=>'3']) !!}
                @else
                {!! Form::$type($item->key.'[]',$item->value, ['class' => 'form-control']) !!}
                @endif
            </div>

        </div>
        @endforeach
        <a target="_blank" href="{!! route('customPostTypeItems.index',$attach->id)!!}">添加更多字段</a>
    </div>
</div>

<?php $o=1;?>
@foreach($all as $item)
<?php $o++;?>
@if($item->slug !=$attach->slug)
<div class="box box-solid" id="{!! $item->
    slug !!}" style="display:none;" >
    <div class="box-header with-border">
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down" data-function="switch-table" data-type="team-table"></a>
        </span>
        <h3 class="box-title">自定义字段</h3>
        <p class="text-muted">
            为 <strong style="color:black;">{!! $item->name !!}</strong>
            单独扩充的字段
        </p>
    </div>
    <!-- /.box-header -->
    <div class="box-body" id="team-table" data-status="show">
        <?php $items=$item->
        postItems()->get();?>
            @if(count($items)==0)
        <div class="form-group">
            <a href="{!! route('customPostTypeItems.index',$item->id)!!}" target="_blank">添加字段</a>
        </div>
        @else
        <?php $a=1+$o;?>
        <!--添加文章时字段默认为空-->
        @foreach($items as $attachs)
        <div class="form-group">
            {!! Form::label($attachs->name, $attachs->des) !!}
            <?php $attr=$attachs->
            type;?>
                @if($attr=='image')
            <?php $a++;?>
            <div class="input-append">
                {!! Form::text($attachs->name.'[]', null, ['class' => 'form-control','id'=>'image'.$a]) !!}
                <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image{!! $a !!}')">选择图片</a>
                <img src="" style="max-width: 100%; max-height: 150px; display: block;"></div>
            @elseif($attr=='select')
            <select class="form-control"  name="{!! $attachs->
                name.'[]' !!}" >
                <?php $list_select_create=explode(',',$attachs->
                value);?>
                   @foreach($list_select_create as $item)
                <option  value="{!! $item !!}">{!! $item !!}</option>
                @endforeach
            </select>
            @elseif($attr=='checkbox')
            <?php $list_select_create=explode(',',$attachs->
            value);?>
                 @foreach($list_select_create as $item)
            <label class="fb">
                {!! Form::checkbox($attachs->name.'[]',$item,false, ['class' => 'custom_checkbox']) !!} {!! $item !!}
            </label>
            @endforeach
                @elseif($attr=='longText')
                {!! Form::textarea($attachs->name.'[]', null, ['class' => 'form-control intro']) !!}
                @elseif($attr=='textarea')
                {!! Form::textarea($attachs->name.'[]',null, ['class' => 'form-control','rows'=>'3']) !!}
                @else
                {!! Form::$attr($attachs->name.'[]', null, ['class' => 'form-control']) !!}
                @endif
        </div>
        @endforeach
            @endif
    </div>
    <!-- /.box-body -->
</div>
@endif
    @endforeach
<!--添加文章时-->
@else
<?php $o=1;?>
@foreach($all as $item)
<?php $o++;?>
<div class="box box-solid" id="{!! $item->
    slug !!}" style="display:none;" >
    <div class="box-header with-border">
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down" data-function="switch-table" data-type="team-table"></a>
        </span>
        <h3 class="box-title">自定义字段</h3>
        <p class="text-muted">
            为
            <strong style="color:black;">{!! $item->name !!}</strong>
            单独扩充的字段
        </p>
        <?php $item_id=$item->id;?></div>
    <!-- /.box-header -->
    <div class="box-body" id="team-table" data-status="show">
        <?php $items=$item->
        postItems()->get();?>
            @if(count($items)==0)
        <div class="form-group">
            <a href="{!! route('customPostTypeItems.index',$item->id)!!}" target="_blank">添加字段</a>
        </div>
        @else
        <?php $a=1+$o;?>
        <!--添加文章时字段默认为空-->
        @foreach($items as $attachs)
        <div class="form-group">
            {!! Form::label($attachs->name, $attachs->des) !!}
            <?php $attr=$attachs->
            type;?>
                @if($attr=='image')
            <?php $a++;?>
            <div class="input-append">
                {!! Form::text($attachs->name.'[]', null, ['class' => 'form-control','id'=>'image'.$a]) !!}
                <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button" onclick="changeImageId('image{!! $a !!}')">选择图片</a>
                <img src="" style="max-width: 100%; max-height: 150px; display: block;"></div>
            @elseif($attr=='select')
            <select class="form-control"  name="{!! $attachs->
                name.'[]' !!}" >
                <?php $list_select_create=explode(',',$attachs->
                value);?>
                   @foreach($list_select_create as $item)
                <option  value="{!! $item !!}">{!! $item !!}</option>
                @endforeach
            </select>
            @elseif($attr=='checkbox')
            <?php $list_select_create=explode(',',$attachs->
            value);?>
                 @foreach($list_select_create as $item)
            <label class="fb">
                {!! Form::checkbox($attachs->name.'[]',$item,false, ['class' => 'custom_checkbox']) !!} {!! $item !!}
            </label>
            @endforeach
                @elseif($attr=='longText')
                {!! Form::textarea($attachs->name.'[]', null, ['class' => 'form-control intro']) !!}
                @elseif($attr=='textarea')
                {!! Form::textarea($attachs->name.'[]',null, ['class' => 'form-control','rows'=>'3']) !!}
                @else
                {!! Form::$attr($attachs->name.'[]', null, ['class' => 'form-control']) !!}
                @endif
        </div>
        @endforeach
            @endif
        <a target="_blank" href="{!! route('customPostTypeItems.index',$item_id)!!}">添加更多字段</a>
    </div>
    <!-- /.box-body -->
</div>
@endforeach
    @endif
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">SEO设置</h3>
        <p class="text-muted">可以为页面单独设置SEO，如果不设置，将使用网站默认设置</p>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('seo_title', 'SEO标题:') !!}
                {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('seo_des', 'SEO描述:') !!}
                {!! Form::text('seo_des', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('seo_keyword', 'SEO关键字:') !!}
                {!! Form::text('seo_keyword', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- /.box-body -->
</div>

</div>