<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="../css/app.css">

</head>
<body>
  <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="/">CT Calc</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item {{ Request::is('calculator') || Request::is('results') ? 'active' : '' }}">
        <a class="nav-link" href="/calculator">Calculator</a>
      </li>
      <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
        <a class="nav-link" href="/about">About</a>
      </li>
    </ul>
  </div>
</nav>

  <div class="container">
    @yield('content')
  </div>

  <script src="../js/jquery-3.2.1.min.js"></script>
  <script src="../js/pub.js"></script>{{-- all js logic here, raw uncompiled --}}
</body>
</html>
