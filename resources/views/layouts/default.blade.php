<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App')</title>
  </head>
  <body>


    @include('layouts._header')

    @include('shared._messages')


    @yield('content')


    @include('layouts._footer')
  </body>
</html>
