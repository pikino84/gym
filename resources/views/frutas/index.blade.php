@extends('layouts.main', ['activePage' => 'frutas', 'titlePage' => 'Frutas'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Frutas</h4>
                  <p class="card-category">Reporte de frutas</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>CIDDOCUMENTO</th>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Semana</th>
                        <th>Fruta</th>
                        <th>Talla</th>
                        <th>Total</th>
                        <th>Pendientes</th>
                      </thead>
                      <tbody>
                        @forelse ($frutas as $fruta)
                        <tr>
                          <td>{{ $fruta->id }}</td>
                          <td>{{ $fruta->cididdocumento }}</td>
                          <td>{{ date('Y-m-d', strtotime($fruta->fecha)) }}</td>
                          <td>{{ $fruta->serie }}</td>
                          <td>{{ $fruta->folio }}</td>
                          <td>{{ $fruta->semana }}</td>
                          <td>{{ $fruta->nombre }}</td>
                          <td>{{ $fruta->talla }}</td>
                          <td>{{ $fruta->total }}</td>
                          <td>{{ $fruta->pendientes }}</td>
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
                  {{ $frutas->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
