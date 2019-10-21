<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App')</title>
  </head>
  <body>


    @include('layouts._header')


    @yield('content')


    @include('layouts._footer')
  </body>
</html>
