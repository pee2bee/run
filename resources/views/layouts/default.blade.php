<!DOCTYPE html>
<html>
  <head>
    <title>@yield("title","run App")--laravel 实战项目</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

      <div class="container">
        <a class="navbar-brand" href="/">run App</a>
        <ul class="navbar-nav justify-content-end">
          <li class="nav-item">
            <a class="nav-link" href="/help">帮助</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"></a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container">
      @yield('content')
    </div>
  </body>
</html>
