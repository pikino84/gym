@extends('layouts.main', ['activePage' => 'users', 'titlePage' => 'Nuevo usuario'])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form action="{{ route('users.store') }}" method="post" class="form-horizontal">
          @csrf
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Usuario</h4>
              <p class="card-category">Ingresar datos</p>
            </div>
            <div class="card-body">
              {{-- @if ($errors->any())
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
              @endif --}}
              <div class="row">
                <label for="name" class="col-sm-2 col-form-label">Nombre completo</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="name" placeholder="Ingrese su nombre completo" value="{{ old('name') }}" autofocus>
                  @if ($errors->has('name'))
                    <span class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="username" class="col-sm-2 col-form-label">Usuario</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="username" placeholder="Ingrese su nombre de usuario" value="{{ old('username') }}">
                  @if ($errors->has('username'))
                    <span class="error text-danger" for="input-username">{{ $errors->first('username') }}</span>
                  @endif
                </div>
              </div>
              
              <div class="row">
                <label for="email" class="col-sm-2 col-form-label">Correo</label>
                <div class="col-sm-7">
                  <input type="email" class="form-control" name="email" placeholder="Ingrese su correo" value="{{ old('email') }}">
                  @if ($errors->has('email'))
                    <span class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                <div class="col-sm-7">
                  <input type="password" class="form-control" name="password" placeholder="Contraseña">
                  @if ($errors->has('password'))
                    <span class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="idproveedor" class="col-sm-2 col-form-label">Razón Social (<b>Solo para proveedores</b>)</label>
                <div class="col-sm-7">
                  <input type="idproveedor" id="idproveedor" class="form-control" name="idproveedor" placeholder="Razón Social Proveedor" autocomplete="off">
                  @if ($errors->has('idproveedor'))
                    <span class="error text-danger" for="input-idproveedor">{{ $errors->first('proveedor') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="roles" class="col-sm-2 col-form-label">Roles</label>
                <div class="col-sm-7">
                  <div class="form-group">
                    <div class="tab-content">
                      <div class="tab-pane active">
                        <table class="table">
                          <tbody>
                            @foreach ($roles as $id => $role)
                            @if ($id != 1 OR $user->username == 'superadmin')
                            <tr>
                              <td>
                                <div class="form-check">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $id }}" >
                                    <span class="form-check-sign">
                                      <span class="check"></span>
                                    </span>
                                  </label>
                                </div>
                              </td>
                              <td>
                                {{ $role }}
                              </td>
                            </tr>
                            @endif
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Footer-->
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{ route('users.index') }}" class="btn btn-primary btn-warning">Volver</a>
            </div>
            <!--End footer-->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
<script>  
  $(document).ready(function() {
    $.ajax({
      url: "http://localhost/laravel/sys/public/api/getUserFromDocuments.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
          let prividersByDocument = response;
          //console.log(proveedores);
          let razonesSociales = [];
          $.each(prividersByDocument, function(index, element) {
            let razonsocial = element.CRAZONSOCIAL;
            console.log(razonsocial);
            razonesSociales.push(razonsocial);
          });
          $("#idproveedor").autocomplete({
            source: razonesSociales
          });
        },
        error: function(xhr, status, error) {
          // Maneja los errores de la solicitud
          console.log('Error en la solicitud: ' + error);
        }
    });
  });
</script>
@endsection
