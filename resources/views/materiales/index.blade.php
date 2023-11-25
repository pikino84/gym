@extends('layouts.main', ['activePage' => 'materiales', 'titlePage' => 'Materiales'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Materiales</h4>
                  <p class="card-category">Reporte de materiales</p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12 col-sm-12 text-right">
                      @can('material_update')
                      <button class="btn btn-refresh btn-facebook" onclick="sendRefresh('{{ route('invoices.refresh_invoices') }}', this)">
                        Actualizar Materiales
                      </button>
                      @endcan
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Productor</th>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Existencia</th>
                      </thead>
                      <tbody>
                        <?php $i = 0; ?>
                        @forelse ($materiales as $material)
                        <?php $i++; ?>
                        <tr>
                          <td>{{ $i }}</td>
                          <td>{{ $material->razonsocial }}</td>
                          <td>{{ $material->cidproducto }}</td>
                          <td>{{ $material->nombre }}</td>
                          <td>{{ number_format($material->entradas, 2, '.', ',') }}</td>
                          <td>{{ number_format($material->salidas, 2, '.', ',') }}</td>
                          <td>{{ number_format($material->existencias, 2, '.', ',') }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="2">Sin registros.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer mr-auto">
                  {{ $materiales->links() }}
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
  
  function sendRefresh(url, button){
    let loading = document.getElementById('loading');
    loading.style.display = 'flex';
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log(url)
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
        loading.style.display = 'none';
        Swal.fire('¡Materiales Actualizados!', 'Los Materiales han sido actualizados.', 'success');
        setTimeout(function() {
            location.reload();
        }, 3000);
      } else {
        loading.style.display = 'none';
        Swal.fire('¡No se actulizaron los Materiales !', 'Lo siento.', 'error');
      }
    })
    .catch(error => {
      
    });
  }
</script>
@endsection
