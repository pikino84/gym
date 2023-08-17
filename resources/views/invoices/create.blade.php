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
                  <input type="text" id="idproveedor" class="form-control" name="id_user" placeholder="Ingresa el ID o nombre del proveedor de la factura" autocomplete="off" autofocus value="{{ old('id_user') }}">
                  @if ($errors->has('id_user'))
                    <span class="error text-danger" for="input-name">{{ $errors->first('id_user') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">ID Factura</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="id_invoice" name="id_invoice" placeholder="Ingresar número de factura" autocomplete="off" autofocus value="{{ old('id_invoice') }}"  >
                  @if ($errors->has('id_invoice'))
                    <span class="error text-danger" for="input-name">{{ $errors->first('id_invoice') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="description" name="description" placeholder="Inresar una descripción" autocomplete="off" autofocus value="{{ old('description') }}" >
                  @if ($errors->has('description'))
                    <span class="error text-danger" for="input-name">{{ $errors->first('description') }}</span>
                  @endif
                </div>
              </div>
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Monto</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="monto" name="monto" placeholder="Ingresa el monto de la factura 0000000.00" autocomplete="off" autofocus value="{{ old('monto') }}" >
                  @if ($errors->has('monto'))
                    <span class="error text-danger" for="input-name">{{ $errors->first('monto') }}</span>
                  @endif
                </div>
              </div>
            </div>
            <input type="hidden" name="fecha" class="fecha" >
            <input type="hidden" name="moneda" class="moneda">
            <input type="hidden" name="tipocambio" class="tipocambio">
            <input type="hidden" name="cancelado" class="cancelado">
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
      url: "https://splendorsys.com/api/getUsers.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
          let proveedores = response;
          let users = [];
          $.each(proveedores, function(index, element) {
            let usersInfo =  element.razonsocial;
            console.log(usersInfo);
            users.push(usersInfo);
          });
          $("#idproveedor").autocomplete({
            source: users,1
            select: function(event, ui) {
              let razonSocial = ui.item.value;
              $.ajax({
                url: "https://splendorsys.com/api/getDocumentsByRazonSocial.php",
                type: "POST",
                data: {
                  razonSocial: razonSocial
                },
                dataType: "json",
                success: function(response) {
                  let documentos = [];
                  $.each(response, function(index, element) {
                    let idDocumento = element.CIDDOCUMENTO;
                    let referencia = element.CREFERENCIA;
                    let monto = element.CTOTAL;
                    let documento = `${idDocumento} | ${referencia} |  ${monto} | ${razonSocial}`;
                    documentos.push(documento);
                  });
                  console.log(documentos);
                  $("#id_invoice").autocomplete({
                    source: documentos, 
                    select: function(event, ui) {
                      // Obtén el valor seleccionado
                      let selectedValue = ui.item.value;
                      console.log(selectedValue);
                      setTimeout(() => {
                        $("#id_invoice").val('');
                        $("#id_invoice").val(selectedValue.split(' | ')[0]);
                        $("#description").val(selectedValue.split(' | ')[1]);
                        $("#monto").val(selectedValue.split(' | ')[2]);  
                        let iddocument = selectedValue.split(' | ')[0]
                        $.ajax({
                          url: "http://splendorsys.com/api/getDocumentByIdDocument.php",
                          type: "POST",
                          data: {
                            iddocument: iddocument
                          },
                          dataType: "json",
                          success: function(response) {
                            console.log(response);
                            $(".fecha").val(response[0].CFECHA.date);
                            $(".moneda").val(response[0].CIDMONEDA);
                            $(".tipocambio").val(response[0].CTIPOCAMBIO);
                            $(".cancelado").val(response[0].CCANCELADO);
                          },
                          error: function(xhr, status, error) {
                            console.log('Error en la solicitud: ' + error);
                          }
                        });
                      }, 200);
                    }
                  });
                },
                error: function(xhr, status, error) {
                  console.log('Error en la solicitud: ' + error);
                }
              });
            }
          });
        },
        error: function(xhr, status, error) {
          console.log('Error en la solicitud: ' + error);
        }
    });
  });
</script>
@endsection
