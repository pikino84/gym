@extends('layouts.main', ['activePage' => 'invoices', 'titlePage' => 'Facturas'])
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Facturas</h4>
                    <p class="card-category">Facturas registradas</p>
                  </div>
                  <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="success">
                      {{ session('success') }}
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-12 text-right">
                        @can('invoice_create')
                        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-facebook">Añadir Factura</a>
                        @endcan
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          <th>#</th>
                          <th>ID factura</th>
                          <th>Productor</th>
                          <th>Descripción</th>
                          <th>Monto</th>
                          <th>Estatus</th>
                          @can('invoice_create')
                          <th>Aprobar</th>
                          <th>Decargar</th>
                          @endcan
                          <th class="text-right">Acciones</th>
                        </thead>
                        <tbody>
                          {{-- dd($invoices) --}}
                          @foreach ($invoices as $invoice)
                            <tr>
                              <td>{{ $invoice->id }}</td>
                              <td>{{ $invoice->id_invoice }}</td>
                              <td>{{ $invoice->razonsocial }}</td>
                              <td>{{ $invoice->description }}</td>
                              <td>${{ number_format($invoice->monto, 2, '.', ',') }} MXN + IVA 0%</td>
                              <td>{{ $invoice->status }}</td>
                              @can('invoice_create')
                              <td  class="td-actions text-center">
                                @if( $invoice->xml != null && $invoice->id_status == 2)
                                <button class="btn btn-facebook" onclick="sendApproval('{{ route('invoices.approved', $invoice->id) }}', this)">
                                  <i class="material-icons">thumb_up</i>
                                </button>
                                @elseif($invoice->id_status == 3)
                                  <a href="javascript:void(0)" class="btn blue-grey lighten-3"><i class="material-icons">thumb_up</i></a>
                                @endif
                              </td>
                              @endcan
                              @can('invoice_create')
                              <td  class="td-actions text-center">
                                @if( $invoice->xml != null )
                                  <a href="{{ route('invoices.download',$invoice->id) }}" class="btn btn-info"><i class="material-icons">cloud_download</i></a>
                                @endif
                              </td>
                              @endcan
                              <td class="td-actions text-right">
                                  <a href="{{ route('invoices.up_docs', $invoice->id) }}" class="btn btn-warning"><i class="material-icons">backup</i></a>
                                  @can('user_show')
                                  <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                  @endcan
                                  @can('user_edit')  
                                  <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                  @endcan
                                  @can('user_destroy')
                                  <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                  @csrf
                                  @method('DELETE')
                                      <button class="btn btn-danger" type="submit" rel="tooltip">
                                      <i class="material-icons">close</i>
                                      </button>
                                  </form>
                                  @endcan
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $invoices->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function sendApproval(url, button) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estás seguro de aceptar esta factura?',
      text: 'Esta acción no se puede deshacer.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Obtener el token CSRF
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Realizar la petición AJAX
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
          },
        })
        .then(response => {
          if (response.ok) {
            // Cambiar el estilo del botón
            button.classList.remove('btn-facebook');
            button.classList.add('blue-grey');
            button.setAttribute('href', 'javascript:void(0)');
            button.removeAttribute('onclick');
            Swal.fire('¡Factura aceptada!', 'La factura ha sido aceptada.', 'success');
          } else {
            Swal.fire('Error', 'Ocurrió un error al aceptar la factura.', 'error');
          }
        })
        .catch(error => {
          Swal.fire('Error', 'Ocurrió un error al aceptar la factura.', 'error');
        });
      }
    });
  }
</script>
@endsection