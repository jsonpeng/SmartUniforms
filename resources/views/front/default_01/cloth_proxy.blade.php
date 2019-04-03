@extends('front.default.layout.mobile_base')

@section('css')
    <style>

    </style>
@endsection

@section('title')
<title>四季校服 专业校服定制</title>
@endsection

@section('content')
<div ><img src="{!! asset('images/proxy1.png') !!}" style="width: 100%;height: auto;" /></div>
<div ><img src="{!! asset('images/proxy2.png') !!}" style="width: 100%;height: auto;" /></div>
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