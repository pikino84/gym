@extends('layouts.main', ['activePage' => 'deudas', 'titlePage' => 'Deudas'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Deudas</h4>
                  <p class="card-category">Reporte de deudas</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Importe</th>
                        <th>Total de unidades</th>
                        <th>Moneda</th>
                        <th>Descuentos</th>
                        <th>Saldo</th>
                      </thead>
                      <tbody>
                        @forelse ($deudas as $deuda)
                        <tr>
                          <td>{{ $deuda->id }}</td>
                          <td>{{ date('Y-m-d', strtotime($deuda->fecha)) }}</td>
                          <td>{{ $deuda->serie }}</td>
                          <td>{{ $deuda->folio }}</td>
                          <td>{{ $deuda->importe }}</td>
                          <td>{{ $deuda->total_unidades }}</td>
                          <td>{{ ($deuda->moneda == 1)?'MXN':'USD' }}</td>
                          <td>{{ $deuda->descuentos }}</td>
                          <td>{{ $deuda->saldo }}</td>
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
                  {{ $deudas->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
