@extends('front.default.layout.mobile_base')

@section('css')
    <style>

    </style>
@endsection

@section('title')
<title>四季校服 专业校服定制 校服代理</title>
@endsection

@section('content')
<a href="tel:{!! getSettingValueByKeyCache('service_tel') !!}" style="display: block;">
    <img src="{!! asset('images/proxy.png') !!}" style="width: 100%;height: auto;" class="proxy_img" />
  {{--   <a class="proxy_a_tel" href="tel:{!! getSettingValueByKeyCache('service_tel') !!}" style="display: none;">t</a> --}}
</a>
</section>
@endsection


@section('js')
<script type="text/javascript">
// $('.proxy_img').click(function(){
//     $('.proxy_a_tel').click();
// });
</script>
@endsection