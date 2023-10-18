@extends('layouts.main', ['activePage' => 'plantas', 'titlePage' => 'Plantas'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Plantas</h4>
                  <p class="card-category">Reporte de plantas</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>CIDDOCUMENTO</th>
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Pendiente</th>
                      </thead>
                      <tbody>
                        @php
                          $cont = 0;
                        @endphp
                        @forelse ($plantas as $planta) 
                        @php
                          $cont++;
                        @endphp
                          <td>{{ $cont }}</td>
                          <td>{{ $planta->cididdocumento }}</td>
                          <td>{{ date('Y-m-d', strtotime($planta->fecha)) }}</td>
                          <td>{{ $planta->semana }}</td>
                          <td>{{ $planta->serie }}</td>
                          <td>{{ $planta->folio }}</td>
                          <td>{{ $planta->concepto }}</td>
                          <td>{{ $planta->importe }}</td>
                          <td>{{ $planta->iva }}</td>
                          <td>${{ number_format($planta->total, 2, '.', ',') }} MXN</td>
                          <td>${{ number_format($planta->pendiente, 2, '.', ',') }} MXN</td>
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
                  <div class="card-footer mr-auto">
                    {{ $plantas->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
