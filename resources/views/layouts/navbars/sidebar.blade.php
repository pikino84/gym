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
      @can('invoice_index')
      <li class="nav-item{{ $activePage == 'invoices' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('invoices.index') }}">
          <i class="material-icons">library_books</i>
          <p>{{ __('Mis facturas') }}</p>
        </a>
      </li>
      @endcan
      
      <li class="nav-item {{ ($activePage == 'frutas' || $activePage == 'plantas' || $activePage == 'plantas' || $activePage == 'prestamos' || $activePage == 'regalias' || $activePage == 'materiales') ? ' active' : '' }}">
        <a class="nav-link collapsed" data-toggle="collapse" href="#account_balance" aria-expanded="false">
          <i class="material-icons">account_balance</i>
          <p>{{ __('Estados de cuenta') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'frutas' || $activePage == 'plantas' || $activePage == 'plantas' || $activePage == 'prestamos' || $activePage == 'regalias' || $activePage == 'materiales') ? ' show' : '' }}" id="account_balance">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'frutas' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('frutas.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">                    
                    <svg fill="#a9afbb" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.31 512.31" xml:space="preserve"  stroke-width="4.09848">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="6.147719999999999"/>
                      <g id="SVGRepo_iconCarrier"> <g> <g> <path d="M412.955,249.91c0-1.6,0-3.2,0-4.8c0-12.8-1.6-24-4.8-35.2c36.8-49.6,56-110.4,51.2-169.6c0-8-6.4-14.4-14.4-14.4 c-68.8-9.6-139.2,11.2-193.6,56c-38.4-43.2-89.6-72-144-81.6c-8-1.6-16,3.2-19.2,9.6c-27.2,68.8-22.4,147.2,14.4,214.4 c-49.6,20.8-83.2,70.4-83.2,128c0,76.8,62.4,137.6,137.6,137.6c33.6,0,64-12.8,88-32c25.6,33.6,67.2,54.4,110.4,54.4 c76.8,0,137.6-62.4,137.6-137.6C492.955,318.71,459.355,270.71,412.955,249.91z M427.355,54.71c0,41.6-11.2,83.2-33.6,118.4 c-8-12.8-17.6-24-28.8-33.6l41.6-40c6.4-6.4,6.4-16,0-22.4c-6.4-6.4-16-6.4-22.4,0l-46.4,44.8c-19.2-9.6-40-16-62.4-16 c-1.6,0-3.2,0-3.2,0C315.355,70.71,371.355,51.51,427.355,54.71z M275.355,137.91c56,0,102.4,44.8,105.6,100.8 c-8-1.6-16-3.2-25.6-3.2c-32,0-64,11.2-88,32c-22.4-28.8-56-49.6-94.4-54.4C185.755,168.31,227.355,137.91,275.355,137.91z M113.755,35.51c48,11.2,89.6,40,121.6,78.4c-16,4.8-32,12.8-44.8,24l-41.6-73.6c-3.2-8-12.8-9.6-20.8-6.4 c-8,4.8-11.2,14.4-6.4,22.4l44.8,78.4c-12.8,16-22.4,35.2-27.2,56c-1.6,0-3.2,0-6.4,0C100.955,158.71,94.555,93.11,113.755,35.51z M156.955,456.31c-59.2,0-105.6-48-105.6-105.6c0-57.6,46.4-105.6,105.6-105.6s105.6,48,105.6,105.6 C262.555,408.31,214.555,456.31,156.955,456.31z M355.355,480.31c-35.2,0-68.8-17.6-88-46.4c17.6-22.4,27.2-51.2,27.2-83.2 c0-19.2-4.8-38.4-11.2-56c19.2-17.6,44.8-28.8,72-28.8c59.2,1.6,105.6,49.6,105.6,108.8 C460.955,433.91,412.955,480.31,355.355,480.31z"/> </g> </g> <g> <g> <path d="M131.355,339.51l4.8-4.8c6.4-4.8,8-16,1.6-22.4c-4.8-6.4-16-8-22.4-1.6l-3.2,1.6l-1.6-3.2c-4.8-8-14.4-9.6-22.4-3.2 c-8,4.8-9.6,14.4-4.8,22.4l4.8,4.8l-4.8,4.8c-6.4,4.8-8,16-1.6,22.4c3.2,3.2,8,6.4,12.8,6.4c3.2,0,6.4-1.6,9.6-3.2l3.2-3.2 l1.6,3.2c3.2,4.8,8,6.4,12.8,6.4c3.2,0,6.4-1.6,9.6-3.2c8-4.8,9.6-14.4,3.2-22.4L131.355,339.51z"/> </g> </g> <g> <g> <path d="M396.955,446.71c-1.6-8-9.6-14.4-19.2-12.8l-33.6,6.4c-9.6,1.6-16,11.2-12.8,19.2c1.6,8,8,12.8,16,12.8c1.6,0,1.6,0,3.2,0 l33.6-6.4C392.155,464.31,398.555,456.31,396.955,446.71z"/> </g> </g> <g> <g> <path d="M288.155,160.31h-32c-9.6,0-16,6.4-16,16c0,9.6,6.4,16,16,16h32c9.6,0,16-6.4,16-16 C304.155,166.71,297.755,160.31,288.155,160.31z"/> </g> </g> </g>
                  </svg>
                  </span>
                  {{ __('Fruta') }}
                </p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'plantas' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('plantas.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>sprout</title><path d="M2,22V20C2,20 7,18 12,18C17,18 22,20 22,20V22H2M11.3,9.1C10.1,5.2 4,6.1 4,6.1C4,6.1 4.2,13.9 9.9,12.7C9.5,9.8 8,9 8,9C10.8,9 11,12.4 11,12.4V17C11.3,17 11.7,17 12,17C12.3,17 12.7,17 13,17V12.8C13,12.8 13,8.9 16,7.9C16,7.9 14,10.9 14,12.9C21,13.6 21,4 21,4C21,4 12.1,3 11.3,9.1Z" /></svg>
                  </span>
                  {{ __('Planta') }}
                </p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'prestamos' ? ' active' : '' }}">
              <a class="nav-link stroke" href="{{ route('prestamos.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg width="30px" height="30px" viewBox="0 0 512.00 512.00" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#a9afbb" stroke="#a9afbb" stroke-width="13.312000000000001">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="6.144"/>
                      <g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#333333;} </style> <g> <path class="st0" d="M274.3,139.6v-6.3c13.4-1.3,22.4-8.9,22.4-20.5c0-3.5-0.6-6.5-2-9.1c-3.1-5.9-9.7-9.8-20.8-12.6V70.9 c3.6,0.8,7.1,2.4,10.8,4.6c1.1,0.6,2.1,1,3.2,1c3.3,0,5.9-2.5,5.9-5.8c0-2.5-1.5-4.1-3.2-5.1c-4.8-3-10.1-5.1-16.3-5.8v-2.3 c0-2.5-2-4.5-4.5-4.5c-2.5,0-4.6,2-4.6,4.5v2.2c-4.1,0.3-7.9,1.3-11,2.9c-3.9,1.9-7,4.8-8.9,8.3c-1.4,2.6-2.2,5.6-2.2,8.9 c0,4.8,1.2,8.6,3.6,11.7c3.5,4.6,9.8,7.6,18.9,9.9v20.7c-5.8-1.1-10.6-3.5-15.6-7c-1-0.7-2.2-1.1-3.5-1.1c-3.3,0-5.8,2.5-5.8,5.8 c0,2.2,1.1,3.9,2.8,5c6.4,4.5,13.7,7.4,21.6,8.2v6.5c0,2.5,2.1,4.5,4.6,4.5C272.3,144.1,274.3,142.1,274.3,139.6z M273.9,103.5 c0.2,0.1,0.3,0.1,0.5,0.2c7.7,2.5,9.9,5.3,9.9,9.8c0,5-3.7,8.4-10.4,9.2V103.5z M265.6,88.9c-1.6-0.5-3-1.1-4.2-1.6c0,0,0,0,0,0 c-4.6-2.2-5.9-4.6-5.9-8.2c0-4.6,3.4-8.2,10.1-8.8V88.9z"/> <path class="st0" d="M225.2,209.3c-26.8-10.5-57.4-5.8-79.9,12.2c-2,1.6-2.9,4.1-2.6,6.5c4.4,28.5,23.7,52.6,50.5,63.1 c9.5,3.7,19.4,5.5,29.3,5.5c13.6,0,27.1-3.4,39.2-10.1v52.4l-53.9-9.9c-1.9-0.3-3.8,0.1-5.4,1.2L139,376.5v-11.3c0-3.9-3.1-7-7-7 H65.1c-3.9,0-7,3.1-7,7v124c0,3.9,3.1,7,7,7H132c3.9,0,7-3.1,7-7v-19.3l216.8,10.3c0.1,0,0.2,0,0.3,0c2.2,0,4.2-1,5.5-2.7 L448.9,365c3.2-4.2,5-9.2,5-14.5c0-8.5-4.6-16.4-12-20.6c-8.4-4.7-18.6-4-26.2,1.9c-0.9,0.7-1.8,1.5-2.7,2.4l-67.6,71.5l-62.9-17.1 l52.3-8.6c3-0.5,5.3-2.8,5.8-5.8l2.1-13.6c0.6-3.7-1.9-7.3-5.7-8l-61.5-11.3v-55c12.1,6.6,25.6,10.1,39.2,10.1 c9.9,0,19.9-1.8,29.3-5.5c26.8-10.5,46.1-34.6,50.5-63.1c0.4-2.5-0.6-5-2.6-6.5c-22.5-18-53.1-22.6-79.9-12.2 c-14.9,5.8-27.6,16-36.6,28.7v-57c42.4-3.6,75.8-39.2,75.8-82.4c0-12.1-2.5-23.8-7.6-34.6c-1.4-3-2.9-5.8-4.5-8.4 c-0.1-0.2-0.2-0.4-0.3-0.6c-11.1-17.8-28.3-30.7-48.5-36.2c-7.1-1.9-14.4-2.9-21.9-2.9c-28.8,0-55.1,14.6-70.3,39.1 c-0.1,0.2-0.2,0.4-0.3,0.6c-1.2,1.9-2.3,3.9-3.3,5.9C188.9,73,186,85.5,186,98.6c0,2.5,0.1,4.8,0.3,6.8 c2.1,26.1,16.8,49.9,39.2,63.7c11,6.8,23.4,10.8,36.3,11.9v56.9C252.7,225.2,240.1,215.1,225.2,209.3z M198.3,278 c-20.9-8.2-36.3-26.4-41-48.1c18.2-12.8,41.9-15.7,62.8-7.6s36.3,26.4,41,48.1C242.8,283.2,219.2,286.2,198.3,278z M125,482.2H72.1 v-110H125v18.1v72.3V482.2z M327.7,367.1L248.5,380c-3.3,0.5-5.7,3.3-5.9,6.5c-0.2,3.3,2,6.3,5.2,7.1l98.1,26.7 c2.5,0.7,5.1-0.1,6.9-1.9l70.4-74.5c0.3-0.4,0.7-0.7,1.1-1c3.1-2.4,7.3-2.7,10.7-0.8c3.1,1.7,4.9,4.9,4.9,8.4c0,2.1-0.7,4.2-2,5.9 L352.8,466L139,455.9v-62.1l69.3-50.5l119.7,22L327.7,367.1z M317.4,222.3c20.9-8.2,44.5-5.2,62.8,7.6c-4.7,21.8-20.1,40-41,48.1 c-20.9,8.2-44.5,5.2-62.8-7.6C281.1,248.7,296.5,230.4,317.4,222.3z M200.2,104.2c-0.2-1.7-0.2-3.5-0.2-5.6 c0-10.9,2.5-21.3,7.3-30.9c0.9-1.8,1.8-3.5,2.8-5.1c0.1-0.1,0.2-0.2,0.2-0.4c12.7-20.3,34.5-32.4,58.4-32.4 c6.2,0,12.3,0.8,18.2,2.4c16.7,4.6,31,15.2,40.2,30c0.1,0.1,0.1,0.2,0.2,0.3c1.4,2.2,2.7,4.6,3.9,7.2c4.2,9,6.3,18.7,6.3,28.8 c0,37.9-30.8,68.8-68.8,68.8c-12.7,0-25.2-3.5-35.9-10.1C214.2,145.7,202,126,200.2,104.2z"/> </g> </g>
                    </svg>
                  </span>
                  {{ __('Préstamos') }}
                </p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'regalias' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('regalias.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>hand-coin</title><path d="M16 12C18.76 12 21 9.76 21 7S18.76 2 16 2 11 4.24 11 7 13.24 12 16 12M21.45 17.6C21.06 17.2 20.57 17 20 17H13L10.92 16.27L11.25 15.33L13 16H15.8C16.15 16 16.43 15.86 16.66 15.63S17 15.12 17 14.81C17 14.27 16.74 13.9 16.22 13.69L8.95 11H7V20L14 22L22.03 19C22.04 18.47 21.84 18 21.45 17.6M5 11H.984V22H5V11Z"></path></svg>
                  </span>
                  {{ __('Regalias') }}
                </p>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'materiales' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('materiales.index') }}">
                <p style="display:flex; align-content: center;">
                  <span style=" width:28px; fill:#a9afbb; margin-right:10px;">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>tractor-variant</title><path d="M13.3 2.79L9.8 6.29L10.5 7L11.9 5.61L13 6.71V9C13 10.11 12.11 11 11 11H10.46A6 6 0 0 1 12 15A6 6 0 0 1 11.91 16H15.03A4.5 4.5 0 0 1 19.5 12A4.5 4.5 0 0 1 22 12.76V8C22 6.89 21.11 6 20 6H13.71L12.61 4.9L14 3.5L13.3 2.79M4 7C3.45 7 3 7.45 3 8C3 8.55 3.45 9 4 9H9C9 7.9 8.11 7 7 7H4M6 10A5 5 0 0 0 4.44 10.25L4.8 11.18L4.33 11.36L4 10.43A5 5 0 0 0 1.54 12.74L2.45 13.15L2.24 13.6L1.34 13.2A5 5 0 0 0 1 15A5 5 0 0 0 1.25 16.56L2.18 16.2L2.36 16.67L1.43 17A5 5 0 0 0 3.74 19.46L4.14 18.55L4.6 18.76L4.2 19.66A5 5 0 0 0 6 20A5 5 0 0 0 7.56 19.75L7.2 18.82L7.67 18.64L8 19.57A5 5 0 0 0 10.46 17.26L9.55 16.86L9.76 16.4L10.66 16.8A5 5 0 0 0 11 15A5 5 0 0 0 10.75 13.44L9.82 13.8L9.64 13.33L10.57 13A5 5 0 0 0 8.26 10.54L7.86 11.45L7.4 11.24L7.8 10.34A5 5 0 0 0 6 10M6 12A3 3 0 0 1 9 15A3 3 0 0 1 6 18A3 3 0 0 1 3 15A3 3 0 0 1 6 12M19.5 13A3.5 3.5 0 0 0 16 16.5A3.5 3.5 0 0 0 19.5 20A3.5 3.5 0 0 0 23 16.5A3.5 3.5 0 0 0 19.5 13M19.5 15A1.5 1.5 0 0 1 21 16.5A1.5 1.5 0 0 1 19.5 18A1.5 1.5 0 0 1 18 16.5A1.5 1.5 0 0 1 19.5 15Z" /></svg>
                  </span>
                  {{ __('Materiales ') }}<span style="font-size: 11px; margin-left:5px">{{ __(' (Sub-Almacén)') }}</span>
                </p>
              </a>
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
