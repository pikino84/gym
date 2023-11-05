@extends('layouts.main', ['activePage' => 'regalias', 'titlePage' => 'Regalias'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Regalias</h4>
                  <p class="card-category">Reporte de regalias</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Productor</th>
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Deuda</th>
                      </thead>
                      <tbody>
                        @forelse ($regalias as $regalia)
                        <tr>
                          <td>{{ $regalia->id }}</td>
                          <td>{{ $regalia->razonsocial }}</td>
                          <td>{{ date('Y-m-d', strtotime($regalia->fecha)) }}</td>
                          <td>{{ $regalia->semana }}</td>
                          <td>{{ $regalia->serie }}</td>
                          <td>{{ $regalia->folio }}</td>
                          <td>{{ $regalia->concepto }}</td>
                          <td>${{ number_format($regalia->importe, 2, '.', ',') }} MXN</td>
                          <td>${{ number_format($regalia->iva, 2, '.', ',') }} MXN</td>
                          <td>${{ number_format($regalia->total, 2, '.', ',') }} MXN</td>
                          <td>${{ number_format($regalia->pendiente, 2, '.', ',') }} MXN</td>
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
                  {{ $regalias->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
