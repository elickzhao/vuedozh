<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard - Vue.js Feed</title>
    <link rel="shortcut icon" href="{{ config('website.icon') }}">
    <!-- Fonts -->
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href={{ asset("/lte/css/bootstrap.min.css") }}>
    <!-- Pnotify -->
    <link href="//cdn.bootcss.com/pnotify/3.0.0/pnotify.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset("/css/pnotify.buttons.css") }}>

    <!-- Font Awesome -->
    <link href="//cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Sweetalert -->
    <link href="//cdn.bootcss.com/limonte-sweetalert2/4.0.5/sweetalert2.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset("/lte/css/AdminLTE.css") }}>
    <link rel="stylesheet" href={{ asset("/lte/css/skin-blue.min.css") }}>

</head>
<body class="skin-blue sidebar-mini">
<script>
    {{--TODO: Remove else when check is done with middleware--}}
    @if(Auth::user())
        const User = {!! Fractal::includes(['role'])->item(Auth::user(), new \App\Transformers\UserTransformer)->getJson() !!};
        User.isAdmin = {{ Auth::user()->isAdmin() }};
    @else
        const User = {isAdmin: false}
    @endif
</script>

{{-- jQuery --}}
<script src={{ asset("/lte/js/jQuery-2.2.0.min.js") }}></script>
{{-- pnotify --}}
<script src="//cdn.bootcss.com/pnotify/3.0.0/pnotify.js"></script>
<script src={{ asset("/js/pnotify.buttons.js") }}></script>
{{-- Sweetalert --}}
<script src="//cdn.bootcss.com/limonte-sweetalert2/4.0.5/sweetalert2.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src={{ asset("/lte/js/bootstrap.min.js") }}></script>
{{-- AdminLTE js --}}
<script src={{ asset("/lte/js/app.min.js") }}></script>
<!-- JavaScripts -->
<script src={{ asset('/js/main.js') }}></script>

<!-- Live Reload -->
@if ( Config::get('app.debug') )
    <script type="text/javascript">
        //document.write('<script src="//localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
    </script>
@endif
</body>
</html>

