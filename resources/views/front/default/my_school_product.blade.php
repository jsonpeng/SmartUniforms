@extends('front.default.layout.base')

@section('css')
    <style>
      ul li{
        display: inline-block; height: 40px; line-height: 40px; padding: 0 10px;
      }
      .hidden{display: none;}
      .varify_btn{
          display: block;
        height: 2.125rem;
        line-height: 2.125rem;
        text-align: center;
      /*  background-color: #3583e8;*/
        font-size: 0.8rem;
        color: #fff;
        margin-left: 80px;
        margin-right: 80px;
      }
    </style>
@endsection

@section('content')
  @if(!Request::get('school_name'))
    <div class="code_varify hidden">
          <div class="container" style="padding-bottom: 0;">
              <div style="height: 15px;"></div>
              <div class="weui-cell">
                  <div class="weui-cell__hd">
                      <label class="weui-label"><span style="color:#fc6a6b">*</span>学校代码</label>
                  </div>
                  <div class="weui-cell__bd">
                      <input class="weui-input" type="text" name="code" maxlength="32" placeholder="请输入我的学校代码后使用" />
                  </div>
              </div>
              <a class="varify_btn weui-btn_primary" href="javascript:;">确定</a>
          </div>
    </div>
   @endif

    <div class="product-wrapper @if(!Request::get('school_name')) hidden @endif" id="scroll-container">
      @foreach ($products as $element)
        <a class="product-item2 scroll-post" href="/product/{{$element->id}}">
            <div class="img">
                <img class="lazy" data-original="{{ $element->image }}">
            </div>
            <div class="title">{{$element->name}}</div>
            <div class="price">¥{{$element->price}} <span class="buynum">{{ $element->sales_count }}人购买</span></div>
        </a>
      @endforeach
    </div>

{{--     <div style="display: none;" id="shopinfo">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div> --}}

{{--     @include(frontView('layout.nav'), ['tabIndex' => 2]) --}}
@endsection


@section('js')
    <script type="text/javascript">
      @if(!Request::get('school_name'))
      $(function(){
         $.zcjyFrameOpen($('.code_varify').html(),'请输入我的学校代码后使用');
      });
      
      $(document).on('click','.varify_btn',function(){
        var val = $('input[name=code]:eq(1)').val();
        if($.empty(val)){
          alert('请输入学校代码');
          return false;
        }
        $.zcjyRequest('/getSchoolInfoByCode',function(res){
          if(res){
            //处理学校
           location.href = '?school_name='+res.school.name;

          }
        },{code:val});

    });
    @endif
    </script>

    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/template" id="template">
        @{{~it:value:index}}
            <a class="product-item2 scroll-post" href="/product/@{{=value.id}}">
              <div class="img">
                  <img src="@{{=value.image }}">
              </div>
              <div class="title">@{{=value.name}}</div>
              <div class="price">¥@{{=value.price}} <span class="buynum">@{{=value.sales_count}}人购买</span></div>
          </a>
        @{{~}}
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
            //无限加载
            var fireEvent = true;
            var working = false;

            $(document).endlessScroll({

                bottomPixels: 250,

                fireDelay: 10,

                ceaseFire: function(){
                  if (!fireEvent) {
                    return true;
                  }
                },

                callback: function(p){

                  if(!fireEvent || working){return;}

                  working = true;

                  //加载函数
                  $.ajaxSetup({ 
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  $.ajax({
                    url:"/api/products?skip=" + $('.scroll-post').length + "&take=18",
                    type:"GET",
                    success:function(data){
                      if (data.status_code != 0) {
                        return;
                      }

                      if (data.data.length == 0) {
                        fireEvent = false;
                        $('#shopinfo').show();
                        return;
                      }
                      if (data.data.length) {
                      // 编译模板函数
                      var tempFn = doT.template( $('#template').html() );

                      // 使用模板函数生成HTML文本
                      var resultHTML = tempFn(data.data);

                      // 否则，直接替换list中的内容
                      $('#scroll-container').append(resultHTML);
                    } else {
                      
                    }
                    working = false;
                    }
                  });
                }
            });
        });
    </script>

@endsection