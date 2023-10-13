<div class="wrapper ">
  <div id="loading">
    <img src="{{ asset('img/loading-loading-forever_1.gif') }}" alt="">
  </div>
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
      @yield('content')
    @include('layouts.footers.auth')
  </div>
</div>