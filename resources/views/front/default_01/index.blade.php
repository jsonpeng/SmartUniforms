@extends('front.default.layout.mobile_base')

@section('css')
    <style>
        .jidingjia_cat{
            font-size: 16px;
            background: black;
            color: white;
            padding: 15px;
            border-radius: 10px;
            /* margin-top: 10px; */
            display: inline-block;
        }
        .jidingjia_cat.active{
           background: rgb(72,159,248);
           color:white;
        }
        .new_item{
            display: inline-grid;
            height: 300px;
            padding-top: 35px;
            padding-right: 25px;
    /* max-width: 150px; */
        }
        .new_item img{
             max-width: 250px;
        }
    </style>
@endsection

@section('title')
<title>四季校服 专业校服定制</title>
@endsection

@section('content')
   <section class="wrapper" style="position: relative;">
    <h2 class="item-title" style="padding-top: 25px;
    font-size: 24px;    padding-bottom: 15px;">校服展示</h2>
    <div class="product-screening">
        <!-- <h4>筛选</h4> -->
        <form id="search_goods_from">

            <a href="javascript:;" data-id="0" class="jidingjia_cat @if(!array_key_exists('cat_id',$input) || array_key_exists('cat_id',$input) && empty($input['cat_id']) ) active @endif">全部</a>
            @foreach ($categories as $category)
                 <a href="javascript:;" data-id="{!! $category->id !!}" class="jidingjia_cat @if(array_key_exists('cat_id',$input) && $input['cat_id'] == $category->id) active @endif">{!! $category->name !!}</a>
            @endforeach
            <input type="hidden" name="cat_id" value="0" />
        </form>
    </div>
    <a href="javascript:;" onclick="$('#search_goods_from').submit();" page="1" class="product-search" style="color: rgb(72,159,248);
    border: 1px solid rgb(72,159,248);
    font-size: 24px;
    /* float: right; */
    /* margin-top: -35px; */
    position: absolute;
    right: 15px;
    top: 70px;">搜索</a>
    <div class="product" style="text-align: center;    margin-bottom: 35px;">
        <ul>
            @foreach ($products as $product)
                <li class="new_item" data-url="/product/{!! $product->id !!}"><img src="{{ $product->image }}" onerror="javascript:this.src='http://www.halfrin.com/show/uploadimg/146475863785770312哈芙琳4050.jpg';" style="height: auto;">
                    <div class="info">
                        <p class="name" style="font-size: 16px;
    padding-top: 5px;">{!! $product->name !!}</p>
                        {{-- <p class="type">新品上市  正装 </p> --}}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="clearfix"></div>
</section>
@endsection


@section('js')
<script type="text/javascript">
    $(function(){
        $('.jidingjia_cat').click(function(){
            $('.jidingjia_cat').removeClass('active');
            $(this).addClass('active');
            $(this).parent().find('input').val($(this).data('id'));
        });
        $('.new_item').click(function(){
            location.href=$(this).data('url');
        })
    });
</script>
@endsection