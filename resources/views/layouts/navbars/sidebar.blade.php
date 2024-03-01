<div class="sidebar" data-color="orange" data-background-color="white" >
  <div class="close__sidebar_movil"><i class="medium material-icons">close</i></div>
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      <img src="{{ asset('img/logo_black.png') }}" width="200" alt="">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <p class=" ml-4 mt-3 text-black "><b>{{ Auth::user()->name }}</b></p>
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      {{-- https://pictogrammers.com/library/mdi/ --}}
      @can('user_index')
      <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="material-icons">person</i>
          <p>Usuarios</p>
        </a>
      </li>
      @endcan
      @can('permission_index')
      <li class="nav-item{{ $activePage == 'permissions' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('permissions.index') }}">
          <i class="material-icons">assignment_ind</i>
          <p>{{ __('Permisos') }}</p>
        </a>
      </li>
      @endcan
      @can('role_index')
      <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('roles.index') }}">
          <i class="material-icons">contacts</i>
          <p>{{ __('Roles') }}</p>
        </a>
      </li>
      @endcan
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons">exit_to_app</i>
          <p>{{ __('Salir') }}</p></a>
      </li>
    </ul>
  </div>
</div>
