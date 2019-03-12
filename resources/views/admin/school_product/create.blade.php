@extends('admin.layouts.app', ['index' => '001'])  

@include('admin.products.partials.css')

@section('content')
<style type="text/css">
        .radio{width: 10%;
                margin-left: 20px;}
        .box{border-top: none;}

    </style>
<section class="content-header pb15-xs" style="margin-bottom: 0;">
    <h1>添加校服</h1>
</section>
<div class="content container-fluid pdall0-xs">
    @include('adminlte-templates::common.errors')
        {!! Form::open(['route' => 'products.sstore']) !!}
    <div class="row">
        <div class="col-sm-8">
            <div class="box mb10-xs">
                <div class="box-body">
                    <div class="form-group">

                        {!! Form::hidden('type', '校服', ['class' => 'form-control']) !!}

                        {!! Form::label('name', '商品名称:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                           {!! Form::label('school_name', '所在学校:') !!}
                            <select class="form-control" name="school_name">
                            <option value="" @if (!isset($product) || empty($product->school_name)) selected="selected" @endif>无</option>
                            @if(count($schools))
                                @foreach($schools as $school)
                                    <option value="{!! $school->name !!}" @if (isset($product) && $product->school_name == $school->name ) selected="selected" @endif>{!! $school->name !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        {!! Form::label('remark', '商品简介:') !!}
                            {!! Form::text('remark', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('image', '图片:') !!}
                        <div class="input-append">
                            <!--input id="fieldID4" type="text" value=""-->
                            {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                            <a data-toggle="modal" href="javascript:;" data-target="#myModal" class="btn" type="button">更改</a>
                            <img src="" style="max-width: 100%; max-height: 150px; display: block;"></div>
                    </div>

                    @if(funcOpen('FUNC_BRAND'))
                    <div class="row">
                        <div class="form-group col-xs-4">
                            {!! Form::label('brand', '商品品牌:') !!}
                                {!! Form::select('brand_id', $brands, null , ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('category', '商品分类:') !!}
                        <div class="row">

                            @if (getSettingValueByKey('category_level') >= 1)
                            <div class="col-xs-4 col-sm-4 pr0-xs">
                                {!! Form::select('level01', $categories, null , ['class' => 'form-control level01']) !!}
                            </div>
                            @endif

                            @if (getSettingValueByKey('category_level') >= 2)
                            <div class="col-xs-4 col-sm-4 pr0-xs">
                                {!! Form::select('level02', ['请选择分类'], null , ['class' => 'form-control level02']) !!}
                            </div>
                            @endif

                            @if (getSettingValueByKey('category_level') >= 3)
                                <div class="col-xs-4 col-sm-4 ">
                                    {!! Form::select('level03', ['请选择分类'], null , ['class' => 'form-control level03']) !!}
                                </div>
                            @endif
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-xs-4">
                            {!! Form::label('price', '校服价格:') !!}
                                {!! Form::text('price', null, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                        </div>

                        <div class="form-group col-xs-4 pr0-xs">
                            {!! Form::label('market_price', '市场价格:') !!}
                                {!! Form::text('market_price', 0, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                        </div>
                        <div class="form-group col-xs-4 pr0-xs">
                            {!! Form::label('cost', '校服成本:') !!}
                                {!! Form::text('cost', 0, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('intro', '商品介绍') !!}
                            {!! Form::textarea('intro', null, ['class' => 'form-control intro']) !!}
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-4 " style="background-color: #fff;">
            <div class="box mb10-xs">
                <div class="box-body">
                    <label class="fb">
                        {!! Form::checkbox('shelf', 1, true, ['class' => 'field minimal']) !!}上架
                    </label>
                </div>
            </div>

            <div class="box">
                <div class="box-body">
                    <!-- Submit Field -->
                    <div class="form-group">
                        {!! Form::submit('下一步', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('products.sindex') !!}" class="btn btn-default">取消</a>
                    </div>
                </div>
            </div>
            
            <!-- 开启分销，并且按商品提成时设置 -->
            @if(funcOpen('FUNC_DISTRIBUTION') && getSettingValueByKey('distribution')=='是' && getSettingValueByKey('distribution_type')=='商品')
                <div class="box">
                    <div class="box-body">
                        <!-- Submit Field -->
                        <div class="form-group">
                            {!! Form::label('commission', '佣金用于提成:') !!}
                            {!! Form::text('commission', 0, ['class' => 'form-control', 'onkeyup' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)', 'onpaste' => 'this.value=this.value.replace(/[^\d.]/g,&quot;&quot;)']) !!}
                        </div>
                    </div>
                </div>
            @endif

            

            <div class="box mb10-xs">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-xs-12 pr0-xs">
                            {!! Form::label('sn', '商品货号:') !!}
                            {!! Form::text('sn', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-xs-12 pr0-xs">
                            {!! Form::label('sort', '排序权重:') !!}
                            {!! Form::number('sort', null, ['class' => 'form-control']) !!}
                            <p class="help-block">权重越高，排序越靠前</p>
                        </div>
                        <!--div class="form-group col-xs-4 pr0-xs">
                            {!! Form::label('sku', 'SKU:') !!}
                            {!! Form::text('sku', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-xs-4">
                            {!! Form::label('spu', 'SPU:') !!}
                            {!! Form::text('spu', null, ['class' => 'form-control']) !!}
                        </div-->
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            {!! Form::label('inventory', '总库存') !!}
                            {!! Form::number('inventory', $defaultInventory, ['class' => 'form-control']) !!}
                            <p class="help-block">用后购买商品会消耗库存，库存消耗完后，用户将无法购买该商品。如果是无限量供应，请将库存设置为-1</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            {!! Form::label('weight', '重量(单位:克):') !!}
                            {!! Form::number('weight', 0, ['class' => 'form-control']) !!}
                            <p class="help-block">用于计算邮费，免邮费可以设置重量为0</p>
                        </div>
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('is_hot', '热销商品:') !!}
                            {!! Form::select('is_hot', [0 => '否', 1 => '是'], null , ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-xs-4">
                        {!! Form::label('is_new', '新品上市:') !!}
                            {!! Form::select('is_new', [0 => '否', 1 => '是'], null , ['class' => 'form-control']) !!}
                    </div>
                    <div class="row">
                        <div class="col-xs-6"> {!! Form::label('words', '校服保障:') !!}</div>
                        <div class="form-group col-xs-12" style="overflow: hidden;">
                            @foreach ($wordlist as $item)
                            <div style="float: left; margin-right: 20px; ">
                                <label>
                                    {!! Form::checkbox('words[]', $item->id, in_array($item->id, $selectedWords)) !!}
                                        {!! $item->name !!}
                                </label>
                            </br>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box visible-xs mb10-xs">
            <div class="box-body">
                <!-- Submit Field -->
                <div class="form-group">
                    {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                    <a href="{!! route('products.index') !!}" class="btn btn-default">取消</a>
                </div>
            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
</div>
@include('admin.partials.imagemodel')
@endsection

@section('scripts')
    @include('admin.products.partials.js')
@endsection