@extends('layouts.main', ['activePage' => 'invoices', 'titlePage' => 'Nueva factura'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" action="{{ route('invoices.store') }}" class="form-horizontal">
          @csrf
          <div class="card ">
            <!--Header-->
            <div class="card-header card-header-primary">
              <h4 class="card-title">Factura</h4>
              <p class="card-category">Ingresar datos de la factura</p>
            </div>
            <!--End header-->
            <!--Body-->
            <div class="card-body">
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Proveedor</label>
                <div class="col-sm-7">
                  <input type="text" id="idproveedor" class="form-control" name="id_user" placeholder="Ingresa el ID o nombre del proveedor de la factura"
                    autocomplete="off" autofocus>
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">ID Factura</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="id_invoice" placeholder="Ingresar número de factura"
                    autocomplete="off" autofocus>
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="description" placeholder="Inresar una descripción"
                    autocomplete="off" autofocus>
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Monto</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="monto" placeholder="Ingresa el monto de la factura 0000000.00"
                    autocomplete="off" autofocus>
                </div>
              </div>
            </div>

            <!--End body-->

            <!--Footer-->
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{ route('invoices.index') }}" class="btn btn-primary btn-warning">Volver</a>
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
      url: "http://splendor.test/api/getUsers.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
          var proveedores = response;
          //console.log(proveedores);
          var users = [];
          $.each(proveedores, function(index, element) {
            var usersInfo = element.id + ' | '+ element.idproveedor + ' | ' + element.razonsocial;
            console.log(usersInfo);
            users.push(usersInfo);
          });
          $("#idproveedor").autocomplete({
            source: users
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
