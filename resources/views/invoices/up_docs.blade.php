@extends('layouts.main', ['activePage' => 'invoices', 'titlePage' => 'Agregar documentos'])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="docs" value="true">
            <div class="card">
                <!--Header-->
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Agregar factura</h4>
                    <p class="card-category">agregar datos de la factura</p>
                </div>
                <!--End header-->
                <!--Body-->
                <div class="card-body">
                    <div class="row">
                        <label for="xml_file" class="col-sm-2 col-form-label">Archivo XML</label>
                        <div class="col-sm-7">
                            <input type="file" id="xml_file" class="form-control" name="xml_file" accept=".xml" required>
                            @if ($errors->has('xml_file'))
                                <span class="error text-danger" for="input-xml_file">{{ $errors->first('xml_file') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="pdf_file" class="col-sm-2 col-form-label">Archivo PDF </label>
                        <div class="col-sm-7">
                            <input type="file" id="pdf_file" class="form-control" name="pdf_file" accept=".pdf" required>
                        </div>
                    </div>
                </div>
                <!--End body-->
                <!--Footer-->
                <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-primary btn-warning">Volver</a>
                </div>
            </div>
            <!--End footer-->
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
          let proveedores = response;
          let users = [];
          $.each(proveedores, function(index, element) {
            let usersInfo =  element.razonsocial;
            //console.log(usersInfo);
            users.push(usersInfo);
          });
          $("#idproveedor").autocomplete({
            source: users,
            select: function(event, ui) {
              let razonSocial = ui.item.value;
              $.ajax({
                url: "http://splendor.test/api/getDocumentsByRazonSocial.php",
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
