@section('scripts')
    <script type="text/javascript">
        function freezeUser(obj,userid){
          var that=obj;
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:"/zcjy/ajax/freezeuser/"+userid,
              type:"POST",
              success:function(data){
                if(data.code==0){
                       layer.msg(data.message, {icon: 1});
                       $(that).parent().html('<span class="btn label label-danger" onclick="freezeUser(this,'+userid+')">取消冻结</span>');
                }else if(data.code==1){
                        layer.msg(data.message, {icon: 1});
                       $(that).parent().html('<span class="btn label label-success" onclick="freezeUser(this,'+userid+')">冻结用户</span>');
                }else{
                       layer.msg(data.message, {icon: 5});
                }   
              }
          });
        }

      function distributeUser(obj,userid) {
        var that=obj;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/ajax/distributeUser/"+userid,
            type:"POST",
            success:function(data){
              if(data.code==0){
                layer.msg(data.message, {icon: 1});
                $(that).parent().html('<span class="btn label label-success" onclick="distributeUser(this,'+userid+')">分销用户</span>');
              }else if(data.code==1){
                layer.msg(data.message, {icon: 1});
                $(that).parent().html('<span class="btn label label-warning" onclick="distributeUser(this,'+userid+')">无分销资格</span>');
              }else{
                layer.msg(data.message, {icon: 5});
              } 
            }
        });
      }


     //积分修改操作
     $('#creditsEdit').click(function(){
      var credits=$(this).parent().find('span').text();
      var userid=$(this).data('id');
       layer.open({
        type: 1,
        closeBtn: false,
        shift: 7,
        shadeClose: true,
        content: "<div style='width:350px;'><div style='width:320px;margin-left: 3%;' class='form-group has-feedback'><p>当前积分</p><input  class='form-control' type='text'  name='credits' value='"+credits+"' disabled/></div>" +
        "<div style='width:320px;margin-left: 3%;' class='form-group has-feedback'><p>输入积分变动</p><input class='form-control' type='number' name='credits_change' value='' /></div>"+
        "<button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary btn-lg' onclick='updateCredits("+userid+")'>修改</button></div>"
         });
     });

     //积分修改对接
     function updateCredits(userid){
        if($('input[name=credits_change]').val()==null || $('input[name=credits_change]').val()==''){
              layer.open({
                    content: '请输入变动值'
                    ,skin: 'msg'
                  });
            return false;
        }
        var credits=parseFloat($('input[name=credits]').val());

        var credits_change=credits_change<0?-parseFloat(-($('input[name=credits_change]').val())):parseFloat($('input[name=credits_change]').val());
        console.log(credits+":"+credits_change);
        var credits_final=credits+credits_change;
        if(credits_change<0 && credits_final<0){
                  layer.open({
                    content: '变动积分不能大于原积分'
                    ,skin: 'msg'
                  });
            return false;
        }
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/ajax/user/"+userid+'/credits_change',
            type:"POST",
            data:{
                credits_change:credits_change
            },
            success:function(data){
              if(data.code==0){
                 layer.msg(data.message, {icon: 1});
                 $('#creditsEdit').parent().find('span').text(credits_final);
                 setTimeout(function(){
                    layer.closeAll();
                 },500); 
              }else{
                 layer.msg(data.message, {icon: 5});
              }
            }
          });
     }

     //余额修改操作
     $('#userMoneyEdit').click(function(){
      var user_money=$(this).parent().find('span').text();
      var userid=$(this).data('id');
       layer.open({
        type: 1,
        closeBtn: false,
        shift: 7,
        shadeClose: true,
        content: "<div style='width:350px;'><div style='width:320px;margin-left: 4%;' class='form-group has-feedback'><p>当前余额</p><input  class='form-control' type='text'  name='user_money' value='"+user_money+"' disabled/></div>" +
        "<div style='width:320px;margin-left: 4%;' class='form-group has-feedback'><p>输入余额变动</p><input class='form-control' type='number' name='user_money_change' value='' /></div>"+
        "<button style='margin-top:5%;width:80%;margin:0 auto;margin-bottom:5%;' type='button' class='btn btn-block btn-primary btn-lg' onclick='updateUserMoney("+userid+")'>修改</button></div>"
         });

     });

     function updateUserMoney(userid){
        if($('input[name=user_money_change]').val()==null || $('input[name=user_money_change]').val()==''){
              layer.open({
                    content: '请输入变动值'
                    ,skin: 'msg'
                  });
            return false;
        }
        var user_money=parseFloat($('input[name=user_money]').val());
        var user_money_change=parseFloat($('input[name=user_money_change]').val());
        var user_money_final=user_money+user_money_change;
        if(user_money_change<0 && user_money_final<0){
                  layer.open({
                    content: '变动余额不能大于原余额'
                    ,skin: 'msg'
                  });
            return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/zcjy/ajax/user/"+userid+'/money_change',
            type:"POST",
            data:{
                money_change:user_money_change
            },
            success:function(data){
              if(data.code==0){
                 layer.msg(data.message, {icon: 1});
                 $('#userMoneyEdit').parent().find('span').text(user_money_final);
                 setTimeout(function(){
                    layer.closeAll();
                 },500); 
              }else{
                 layer.msg(data.message, {icon: 5});
              }
            }
          });
     }
    </script>
@endsection