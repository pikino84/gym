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
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Productor</th>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Unidades Agregadas</th>
                        <th>Unidades Restadas</th>
                      </thead>
                      <tbody>
                        @forelse ($materiales as $material)
                        <tr>
                          <td>{{ $material->id }}</td>
                          <td>{{ $material->razonsocial }}</td>
                          <td>{{ $material->cidproducto }}</td>
                          <td>{{ $material->nombre }}</td>
                          <td>{{ $material->u_agregadas }}</td>
                          <td>{{ $material->u_restadas }}</td>
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
