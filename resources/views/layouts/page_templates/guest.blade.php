@include('layouts.navbars.navs.guest')
<div class="wrapper wrapper-full-page">
  <div class="page-header login-page header-filter" filter-color="black" style="background-color: #3b3838; background-size: cover; background-position: top center;align-items: center;" data-color="green">
    @yield('content')
    @include('layouts.footers.guest')
  </div>
</div>
