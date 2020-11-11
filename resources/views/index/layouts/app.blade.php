<!DOCTYPE html>
<!--这里要好好研究研究-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title','首页') - {{setting('webname')}}</title>
    <link rel="stylesheet" href="{{asset('static/css/bootstrap.min.css')}}">
    <link href="https://cdn.bootcss.com/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('static/css/index.css')}}?{{time()}}">
    @yield('css')
</head>

<body>
    @include('index.layouts.nav')
    <div class="container">
        <div class='row mb-2 mt-2'>
            <div class='col-12'>
                <img src="{{asset('static/images/toutu.png')}}" class='img-fluid' style="width: 100%;">
            </div>
        </div>
        <div class='row mb-2 mt-2'>
            <div class='col-12'>
                <nav aria-label="breadcrumb">
                    <ol class='breadcrumb'>
                        <li class='breadcrumb-item'><a href="{{route('index')}}">首页</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>
        <div class='row'>
            <div class='col-9'>
                @yield('content')
            </div>
            <div class='col-3'>
                @yield('sidebar')
            </div>
        </div>
    </div>

    <div class='container-fluid'>
        <div class='row mt-3'>
            <div class='col-12 bg-dark p-5 text-center align-middle text-muted'>
                <p>该软件为【编程实验室】系列课程作品，并作为开源软件。</p>
                <p>官方网站【<a href="http://www.sodevel.com" class='text-muted'>编程实验室</a>】，作者工作微信：pmtt9121</p>
            </div>
        </div>
    </div>
    <script src="{{asset('static/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('static/js/popper.min.js')}}"></script>
    <script src="{{asset('static/js/bootstrap.min.js')}}"></script>
    @yield('js')
</body>

</html>