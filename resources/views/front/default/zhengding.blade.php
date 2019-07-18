@extends('front.default.layout.base')

@section('css')
<style type="text/css">
body{
    background-color: #f4f2f3;
}

.weui-cells:before{border-top:0;}

.teshu-text p{
    padding: 0.875rem 0.75rem 0.5rem 0.75rem;
    font-size: 14px;
    line-height: 20px;
}

.teshu-text p>strong{
    color: red;
}
.weui-cells_radio{
    display: flex;
}
.weui-cells_radio .weui-icon-checked:before{
    content: '\EA01';
    color: #C9C9C9;
    font-size: 23px;
    display: block;
}

.weui-cells_radio .weui-check:checked + .weui-icon-checked:before{
    content: '\EA06';
    color: #09BB07;
    display: block;
    font-size: 23px;
}

.container {
  padding-bottom: 2.225rem;
}
.container .user_info .weui-media-box {
  color: #333;
}
.container .user_info .weui-media-box .weui-media-box__bd {
  margin-left: 0.25rem;
}
.container .user_info .weui-media-box .weui-media-box__bd .weui-media-box__title {
  font-size: 0.6rem;
}
.container .member_tequ {
  padding: 0.75rem 0.75rem 2rem;
}
.container .member_tequ h5 {
  font-size: 14px;
  color: #70768b;
  margin: 0;
  line-height: 1rem;
}
.container .member_tequ .content {
  font-size: 14px;
  color: #70768b;
  line-height: 1rem;
}
.container .agree {
  padding: 0.5rem 0.75rem;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  font-size: 0.6rem;
  color: #333;
}
.container .agree a {
  color: #3583e8;
}
.container .agree .service {
  width: 0.5rem;
  height: 0.5rem;
}
.container .buy_btn {
  display: block;
  margin: 0 0.75rem;
  height: 1.75rem;
  line-height: 1.75rem;
  text-align: center;
  background-color: #3583e8;
  font-size: 0.7rem;
  color: #fff;
}
form .company_fill,
form .contact_fill {
  padding: 0.5rem;
  font-size: 14px;
  color: #70768b;
}
form .weui-cell {
  background-color: #fff;
  padding: 0.25rem 0.75rem;
}
form .weui-cell .weui-cell__bd {
  font-size: 0.6rem;
  color: #b6b6b6;
}
form .weui-cell .weui-cell__bd .weui-input {
  padding-left: 0.4rem;
}
form .weui-cell .weui-cell__hd {
  font-size: 0.6rem;
  color: #333;
}
form .weui-cell .weui-cell__hd .weui-label {
  min-width: 4rem;
}
form .weui-cell .item_price {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
}
form .weui-cell .item_price span {
  color: #333;
}
form .weui-cell_select .weui-cell__bd .weui-select {
  padding-left: 0.4rem;
}
form .weui-cells {
  margin-top: 0;
}
form .weui-cells_radio {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
}
form .weui-cells_radio .weui-check__label {
  min-width: 2.5rem;
  padding: 0.25rem 0.75rem;
}
form .onload {
  padding: 0.75rem;
  background-color: #fff;
}
form .onload img {
  width: 2.2rem;
  height: 2.2rem;
}
form .onload p {
  font-size: 14px;
  color: #b6b6b6;
}
form .submit_btn{
  display: block;
  height: 2.125rem;
  line-height: 2.125rem;
  text-align: center;
/*  background-color: #3583e8;*/
  font-size: 0.8rem;
  color: #fff;
}

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
form input[type="file"] {
  display: none;
}
#schools-tbody-show  input{
  max-width: 35px;
  text-align: center;
}
#schools-tbody-show  select{
  max-width: 80px;
  text-align: center;
}   
.hidden{
  display: none;
}
</style>
@endsection

@section('title')
    <title>校服征询单</title>
@endsection

@section('content')
   <div class="code_varify hidden">
        <div class="container" style="padding-bottom: 0;">
            <div style="height: 15px;"></div>
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><span style="color:#fc6a6b">*</span>学校代码</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="code" maxlength="32" placeholder="请输入我的学校代码后使用">
                </div>
            </div>
            <a class="varify_btn weui-btn_primary" href="javascript:;">确定</a>
        </div>
  </div>

   <div class="container" style="padding-bottom: 0;display: none;">
        <form  id="form_project_create" enctype="multipart/form-data">
       
            <h3 class="contact_fill">
                <span style="padding-left: 0.4rem;">请填写联系方式</span>
            </h3>

    {{--         <div class="weui-cell weui-cell_select">
                <div class="weui-cell__bd">
                    <select class="weui-select" name="school_name">
                        <option selected value="">请选择学校</option>
                        @if(count($schools))
                          @foreach ($schools as $item)
                             <option  value="{!! $item->name !!}">{!! $item->name !!}</option>
                          @endforeach
                        @endif
                    </select>
                </div>
            </div> --}}
            <input type="hidden" name="type" value="征订单" />
            <input type="hidden" name="school_name" value="" />
            <input type="hidden" name="user_id" value="@if(auth('web')->user()) {!! auth('web')->user()->id !!} @endif" />
           <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><span style="color:#fc6a6b">*</span>学生姓名</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="name" maxlength="32" placeholder="学生姓名">
                </div>
            </div>
          
            <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label"><span style="color:#fc6a6b">*</span>性别</label>
                    </div>
                   <div class="weui-cells weui-cells_radio">
                        <label class="weui-cell weui-check__label" for="sex1">
                            <div class="weui-cell__bd">
                                <p>男</p>
                            </div>
                            <div class="weui-cell__ft">
                                <input type="radio" class="weui-check" checked="checked" name="sex" id="sex1" value="男" >
                                <i class="weui-icon-checked"></i>
                            </div>
                        </label>
                        <label class="weui-cell weui-check__label" for="sex2">
                            <div class="weui-cell__bd">
                                <p>女</p>
                            </div>
                            <div class="weui-cell__ft">
                                <input type="radio" name="sex" class="weui-check"  value="女" id="sex2" >
                                <i class="weui-icon-checked"></i>
                            </div>
                        </label>
                    </div>
            </div>

                <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><span style="color:#fc6a6b">*</span>班级</label>
                </div>
                <div class="weui-cell__bd">
                      <select class="weui-select" name="class">
                        <option selected value="">请选择班级</option>
                       
                      </select>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label"><span style="color:#fc6a6b">*</span>家长联系方式</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="commit"  maxlength="11" onkeyup="value=value.replace(/[^\d]/g,'')" placeholder="请输入联系方式">
                </div>
            </div>
    
            <h3 class="company_fill">
                <span style="color:#fc6a6b">*</span> 请填写学生身高体重信息
            </h3>
            <div class="weui-cell">
                <div class="weui-cell__hd" >
                    <label class="weui-label">学生身高(约)</label>
                </div>
                <div class="weui-cell__bd item_price">
                    <input class="weui-input" type="text" name="shengao" maxlength="8"  onkeyup="value=value.replace(/[^\d]/g,'')" placeholder="请填写学生身高">
                    <span style="width:50px;">CM</span>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd" >
                    <label class="weui-label">学生体重(约)</label>
                </div>
                <div class="weui-cell__bd item_price">
                    <input class="weui-input" type="text" name="tizhong" maxlength="8"  onkeyup="value=value.replace(/[^\d]/g,'')" placeholder="请填写学生体重">
                    <span style="width:50px;">公斤</span>
                </div>
            </div>

              <div class="weui-cell weui-cell_select choose_clothes">
                    <div class="weui-cell__bd" style="color: red;font-size: 26px;">
                        <strong>我的校服</strong>
                    </div>
              </div>

              <div class="weui-cell ">
                      <table class="table table-responsive" id="products-table" style="width: 100%;
          margin-bottom: 15px;
          overflow-y: hidden;
          -ms-overflow-style: -ms-autohiding-scrollbar;
          border: 1px solid #ddd;">
                            <thead>
                                <tr>
                                <th>校服名称</th>
                                <th>尺码</th>
                                <th>价格</th>
                                <th>征订</th>
                          {{--       <th>退回</th> --}}
                                <th>操作</th>
                            </tr></thead>
                            <tbody id="schools-tbody-show">
                                
                            </tbody>
                     </table>
                     <div class="school_table hidden">
                          <table>
                           <tbody id="schools-tbody">
                            <tr >
                              <td class="pname">
                                  <select name="pname[]" class="choose_product_action">
                                  {{--   @if(count($products))
                                      @foreach ($products as $item)
                                          <option value="{!! $item->name !!}">{!! $item->name !!}</option>
                                      @endforeach
                                    @endif --}}
                                  </select>
                              </td>
                              {{-- <input type="hidden" name="pname[]" class="pname_input" value="" /> --}}
                              <td class="chima">
                                <select name="chima[]" class="choose_chima_action">
                                      <option value="">请选择尺码</option>
                                      <option value="尺码:90">尺码:90</option>
                                      <option value="尺码:100">尺码:100</option>
                                      <option value="尺码:110">尺码:110</option>
                                      <option value="尺码:120">尺码:120</option>
                                      <option value="尺码:130">尺码:130</option>
                                      <option value="尺码:140">尺码:140</option>
                                      <option value="尺码:150">尺码:150</option>
                                      <option value="尺码:155">尺码:155</option>
                                      <option value="尺码:160">尺码:160</option>
                                      <option value="尺码:165">尺码:165/S</option>
                                      <option value="尺码:170">尺码:170/M</option>
                                      <option value="尺码:175">尺码:175/L</option>
                                      <option value="尺码:180">尺码:180/XL</option>
                                </select></td>
                             
                              <!-- <td class="price">0</td> -->
                              <td><input type="text" name="price[]" class="price_input" value="0" readonly="true" /></td>
                              <td><input name="zengding[]" type="number" class="zengding_input" value="1" /></td>
                          {{--     <td></td> --}}
                              <input name="tuihui[]" type="hidden"  value="0" />
                              <td onclick="$(this).parent().remove();">删除</td>
                            </tr>
                            </tbody>
                          </table>
                     </div>

               

              </div>

             <div class="weui-cell ">
               <div class="weui-cell__hd" >
                      <label class="weui-label" style="font-size: 16px;"><h4 >总价:<span class="total_price" style="color:red;">0</span></h4></label>
               </div>
             </div>


            
            <h3 class="contact_fill">
                <span style="padding-left: 0.4rem;">特别说明 :</span>
            </h3>
            <div style="background: #fff;" class="teshu-text"> 
                <p><strong>★</strong>请点击我的校服选择指定的校服进行选择,如想添加更多校服可继续点击我的校服进行添加</p>
                <p><strong>★</strong>校服和尺码可通过下拉选择自己孩子合适的即可。</p>
                <p><strong>★</strong>提交表格后可在个人中心进行查看。</p>
                <p><strong>★</strong>若取得校服明显不合身，无期限可以提出调换，请保持原有标牌，不要有污垢、破损和水洗。</p>
                <p><strong>★</strong>身高和体重不必精确,校服已预作适当调节放量</p>
                <p><strong>★</strong>特殊身材指显著宽胖体型,务必备注填写好腰围胸围,偏胖身材征订时增加一个型号即可。</p>
            </div>

            <h3 class="contact_fill">
                <span style="padding-left: 0.4rem;">对照表 :</span>
            </h3>

            <div >
              <img src="/images/duizhao.png" style="width: 100%;height:auto;" />
            </div>

            <h3 class="contact_fill">
                <span style="padding-left: 0.4rem;">家长备注 :</span>
            </h3>
            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <textarea class="weui-textarea" name="remark" placeholder="请填写备注信息" maxlength="150" rows="5"></textarea>
                    <div class="weui-textarea-counter"><span>0</span>/150</div>
                </div>
            </div>
          
       
            <a class="submit_btn weui-btn_primary" href="javascript:;">核对</a>
        </form>
        <div class="shade"></div>
    </div>


<div id="product_items_table" style="display: none;"> </div>
@endsection


@section('js')
<script type="text/javascript">

  //先输入学校代码
  $(function(){
     $.zcjyFrameOpen($('.code_varify').html(),'请输入我的学校代码后使用');
  });

  //然后开始填写
  $(document).on('click','.varify_btn',function(){
      var val = $('input[name=code]:eq(1)').val();
      if($.empty(val)){
        alert('请输入学校代码');
        return false;
      }
      $.zcjyRequest('/getSchoolInfoByCode',function(res){
        if(res){
          //处理学校
          $('input[name=school_name]').val(res.school.name);
          $('title').text('['+res.school.name+']'+$('title').text());
          var products = res.products;
          //处理商品
          var html = '<option value>请选择校服</option>';
          for(var i =0;i<products.length;i++){
            html += '<option value='+products[i]['name']+'>'+products[i]['name']+'</option>';
          }
          $('.choose_product_action').html(html);
          //根据学校名称获取班级
          $.zcjyRequest('/getClassesBySchoolName',function(res2){
                  if(res2){
                        var html = '';
                        for(var i =0;i<res2.length;i++){
                          html += '<option value='+res2[i]['name']+'>'+res2[i]['name']+'</option>';
                        }
                        $('select[name=class]').html(html);
                        $('.choose_clothes').trigger('click');
                  }
          },{name:res.school.name});
          layer.closeAll();
          $('.container').show();
        }
      },{code:val});
  });

  function scrollToLocation(obj) {
    $('html,body').animate({
      scrollTop:obj.offset().top-obj.height()-35
    },800)
  }

  var had_hedui = 0;

  $('.submit_btn').click(function(){

    if(dealInputName('school_name','请选择学校')){
      return false;
    }

    if(dealInputName('name','请输入学生姓名')){
      return false;
    }

    if(dealInputName('class','请输入学生班级')){
      return false;
    }

    if(dealInputName('shengao','请输入学生身高')){
      return false;
    }

    if(dealInputName('tizhong','请输入学生体重')){
      return false;
    }

    if(dealInputName('commit','请输入联系方式')){
      return false;
    }

    if($('input[name=commit]').val().length < 11){
      alert('请输入正确的联系方式');
      return;
    }

    if(!had_hedui){

      alert('请仔细核对');

      scrollToLocation($('body'));

      had_hedui = 1;

      $(this).text('提交');

      return false;

    }

   $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
   $.ajax({
        url:'/create_consult',
        type:'POST',
        data:$('form').serialize(),
        success:function(data){
          if(data.code==0){
            alert(data.message);   
            location.href="/consultRecords/征订单";    
          }else{
            alert(data.message);
          }
        }
    });
  });


  //添加校服
  $('.choose_clothes').click(function(){
      //  $.zcjyFrameOpen('/searchSchoolsFrame','请选择校服');
      $('#schools-tbody-show').append($('.school_table').find('tbody').html());
  });

  //选择商品更新规格
  $(document).on('change','.choose_product_action',function(){
        var that = this;
        if(!$.empty($(that).val())){
          $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
         $.ajax({
              url:'/getProductGuiGeByName',
              type:'GET',
              data:{name:$(that).val()},
              success:function(data){
                if(data.code==0){
                  var arr = data.message;
                  var html ='<option >请选择规格</option>';
                  for(var i= arr.length-1;i>=0;i--){
                      html += '<option value='+arr[i]+'>'+arr[i]+'</option>';
                  }
                  $(that).parent().parent().find('.choose_chima_action').html(html);
                  // $(that).parent().parent().find('.choose_chima_action').trigger('change');
                }else{
                  alert(data.message);
                }
              }
          });
      }
  });

  //选择规格更新价格
  $(document).on('change','.choose_chima_action',function(){
      var that =this;
      if(!$.empty($(that).val())){
          $.zcjyRequest('/getPriceByNameAndChima',function(res){
                $(that).parent().parent().find('.price_input').val(res);
                countAllPrice();
                 layer.confirm('规格选择完毕,是否继续添加校服?', {
                  btn: ['确定','提交成功'] //按钮
                }, function(){
                  layer.closeAll();
                  $('.choose_clothes').trigger('click');
                }, function(){
                  $('.submit_btn').trigger('click');
                  // location.href = '/consultRecords';
                });
          },{name:$(that).parent().parent().find('.choose_product_action').val(),key:$(that).val()});
      }
   });
  

  //统计字数
  $(".weui-textarea").on('blur keyup input',function(){  
        var text=$(this).val();  
        var counter=text.length;  
        $(this).parent().find('span').text(counter);  
    }); 

  function dealInputName(inputName,chineseInfo){
    var status = false;
    $('input[name='+inputName+'],select[name='+inputName+']').each(function(){
      if($(this).val() == '' || $(this).val() == null){
        status = true;
        alert(chineseInfo);
      }
    });
    return status; 
  }

  function call_back_by_many(table_html) {

    $('#product_items_table').html(table_html);

    layer.closeAll('iframe');

    
    //从已经选中的中找出选中的并且遍历
    $('#product_items_table').find('.trSelected').each(function() {
        var spec_id = $(this).data("specid");
        var productname = $(this).data("productname");
        var price = $(this).data("price");
        var keyname = $(this).data("keyname");
        var productid = $(this).data("productid");
        //校服名称
        $('.school_table').find('.pname').html(productname);
        $('.school_table').find('.pname_input').val(productname);
        //价格
        $('.school_table').find('.price').html(price);
        $('.school_table').find('.price_input').val(price);
        //尺码
        $('.school_table').find('.chima').find('option').removeAttr('selected');
        $('.school_table').find('.chima').find("option[value = '"+keyname+"']").attr('selected','selected');
 
        //console.log($('.school_table').html());
        $('#schools-tbody-show').append($('.school_table').find('tbody').html());
      
    });
   
 }


function countAllPrice(){
   var all =0; 
    $('#schools-tbody-show').children('tr').each(function(){
        var price =parseFloat($(this).find('.price_input').val());
        var num = parseInt($(this).find('input[type=number]').val());
        all += price*num;
    });
    $('.total_price').text(all);
}

$(document).on('keyup','.zengding_input',function(){
    countAllPrice();
});

</script>
@endsection
