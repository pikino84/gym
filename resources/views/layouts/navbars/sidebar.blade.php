<div class="sidebar" data-color="orange" data-background-color="white" >
  <div class="close__sidebar_movil"><i class="medium material-icons">close</i></div>
  <div class="logo">
    <a href="{{ route('home') }}" class="simple-text logo-normal">
      <img src="{{ asset('img/logo.png') }}" alt="">
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
      {{--
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('img/laravel.svg') }}"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
       --}}
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
      @can('invoice_index')
      <li class="nav-item{{ $activePage == 'invoices' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('invoices.index') }}">
          <i class="material-icons">library_books</i>
          <p>{{ __('Mis facturas') }}</p>
        </a>
      </li>
      @endcan
      
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'usaccount-status') ? ' active' : '' }}">
        <a class="nav-link collapsed" data-toggle="collapse" href="#account_balance" aria-expanded="false">
          <i class="material-icons">account_balance</i>
          <p>{{ __('Estados de cuenta') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse " id="account_balance">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'frutas' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('frutas.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>fruit-watermelon</title><path d="M16.4 16.4C19.8 13 19.8 7.5 16.4 4.2L4.2 16.4C7.5 19.8 13 19.8 16.4 16.4M16 7C16.6 7 17 7.4 17 8C17 8.6 16.6 9 16 9S15 8.6 15 8C15 7.4 15.4 7 16 7M16 11C16.6 11 17 11.4 17 12C17 12.6 16.6 13 16 13S15 12.6 15 12C15 11.4 15.4 11 16 11M12 11C12.6 11 13 11.4 13 12C13 12.6 12.6 13 12 13S11 12.6 11 12C11 11.4 11.4 11 12 11M12 15C12.6 15 13 15.4 13 16C13 16.6 12.6 17 12 17S11 16.6 11 16C11 15.4 11.4 15 12 15M8 17C7.4 17 7 16.6 7 16C7 15.4 7.4 15 8 15S9 15.4 9 16C9 16.6 8.6 17 8 17M18.6 18.6C14 23.2 6.6 23.2 2 18.6L3.4 17.2C7.2 21 13.3 21 17.1 17.2C20.9 13.4 20.9 7.3 17.1 3.5L18.6 2C23.1 6.6 23.1 14 18.6 18.6Z" /></svg>
                  </span>
                  {{ __('Frutas') }}
                </p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link collapsed" data-toggle="collapse" href="#credits" aria-expanded="false">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>pig-variant</title><path d="M19.83 7.5L17.56 5.23C17.63 4.81 17.74 4.42 17.88 4.08C17.96 3.9 18 3.71 18 3.5C18 2.67 17.33 2 16.5 2C14.86 2 13.41 2.79 12.5 4H7.5C4.46 4 2 6.46 2 9.5S4.5 21 4.5 21H10V19H12V21H17.5L19.18 15.41L22 14.47V7.5H19.83M16 11C15.45 11 15 10.55 15 10S15.45 9 16 9C16.55 9 17 9.45 17 10S16.55 11 16 11Z" /></svg>
                  </span>
                  {{ __('Creditos') }}
                  <b class="caret"></b>
                </p>
              </a>
              {{--CREDITOS --}}
              <div class="collapse " id="credits">
                <ul class="nav">
                  <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('deudas.index') }}">
                      <p style="display:flex; align-content: center;">
                        <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>home-silo</title><path d="M24 7.8C23.6 4.5 20.9 2 17.5 2C15.8 2 14.1 2.7 12.9 3.9C12.2 4.6 11.7 5.3 11.4 6.2L17 9.9V10H20V12H17V14H20V16H17V18H20V20H17V22H24V7.8M13.3 7C13.9 5.2 15.6 4 17.5 4S21.1 5.2 21.7 7H13.3M0 11V22H5V15H10V22H15V11L7.5 6L0 11Z" /></svg>
                        </span>
                        {{ __('Planta') }}
                      </p>
                    </a>
                  </li>
                  <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('regalias.index') }}">
                      <p style="display:flex; align-content: center;">
                        <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>sprout</title><path d="M2,22V20C2,20 7,18 12,18C17,18 22,20 22,20V22H2M11.3,9.1C10.1,5.2 4,6.1 4,6.1C4,6.1 4.2,13.9 9.9,12.7C9.5,9.8 8,9 8,9C10.8,9 11,12.4 11,12.4V17C11.3,17 11.7,17 12,17C12.3,17 12.7,17 13,17V12.8C13,12.8 13,8.9 16,7.9C16,7.9 14,10.9 14,12.9C21,13.6 21,4 21,4C21,4 12.1,3 11.3,9.1Z" /></svg>
                        </span>
                        {{ __('Capital de trabajo') }}
                      </p>
                    </a>
                  </li>
                  <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('financiamientos.index') }}">
                      <p style="display:flex; align-content: center;">
                        <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>tractor-variant</title><path d="M13.3 2.79L9.8 6.29L10.5 7L11.9 5.61L13 6.71V9C13 10.11 12.11 11 11 11H10.46A6 6 0 0 1 12 15A6 6 0 0 1 11.91 16H15.03A4.5 4.5 0 0 1 19.5 12A4.5 4.5 0 0 1 22 12.76V8C22 6.89 21.11 6 20 6H13.71L12.61 4.9L14 3.5L13.3 2.79M4 7C3.45 7 3 7.45 3 8C3 8.55 3.45 9 4 9H9C9 7.9 8.11 7 7 7H4M6 10A5 5 0 0 0 4.44 10.25L4.8 11.18L4.33 11.36L4 10.43A5 5 0 0 0 1.54 12.74L2.45 13.15L2.24 13.6L1.34 13.2A5 5 0 0 0 1 15A5 5 0 0 0 1.25 16.56L2.18 16.2L2.36 16.67L1.43 17A5 5 0 0 0 3.74 19.46L4.14 18.55L4.6 18.76L4.2 19.66A5 5 0 0 0 6 20A5 5 0 0 0 7.56 19.75L7.2 18.82L7.67 18.64L8 19.57A5 5 0 0 0 10.46 17.26L9.55 16.86L9.76 16.4L10.66 16.8A5 5 0 0 0 11 15A5 5 0 0 0 10.75 13.44L9.82 13.8L9.64 13.33L10.57 13A5 5 0 0 0 8.26 10.54L7.86 11.45L7.4 11.24L7.8 10.34A5 5 0 0 0 6 10M6 12A3 3 0 0 1 9 15A3 3 0 0 1 6 18A3 3 0 0 1 3 15A3 3 0 0 1 6 12M19.5 13A3.5 3.5 0 0 0 16 16.5A3.5 3.5 0 0 0 19.5 20A3.5 3.5 0 0 0 23 16.5A3.5 3.5 0 0 0 19.5 13M19.5 15A1.5 1.5 0 0 1 21 16.5A1.5 1.5 0 0 1 19.5 18A1.5 1.5 0 0 1 18 16.5A1.5 1.5 0 0 1 19.5 15Z" /></svg>
                        </span>
                        {{ __('Materiales') }}</p>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="material-icons">exit_to_app</i>
          <p>{{ __('Salir') }}</p></a>
      </li>
    </ul>
  </div>
</div>
