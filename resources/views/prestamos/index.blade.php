@extends('layouts.main', ['activePage' => 'prestamos', 'titlePage' => 'Prestamos'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Prestamos</h4>
                  <p class="card-category">Reporte de prestamos</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Productor</th>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Prestamos</th>
                        <th>Descuentos</th>
                        <th>Deuda</th>
                      </thead>
                      <tbody>
                        @php
                          $cont = 0;
                          $totalPrestamos = 0;
                          $totalDescuentos = 0;
                        @endphp
                        @forelse ($prestamos as $prestamo) 
                        @php
                          $cont++;
                        @endphp
                          <td>{{ $cont }}</td>
                          <td>{{ $prestamo->razonsocial }}</td>
                          <td>{{ date('Y-m-d', strtotime($prestamo->fecha)) }}</td>
                          <td>{{ $prestamo->serie }}</td>
                          <td>{{ $prestamo->folio }}</td>
                          @if ($prestamo->naturaleza == 0)
                            @php
                              $totalPrestamos += $prestamo->total;
                            @endphp
                            <td>${{ number_format($prestamo->total, 2, '.', ',') }} MXN</td>
                            <td></td>
                          @else
                            <td></td>
                            @php
                              $totalDescuentos += $prestamo->total;
                            @endphp
                            <td>${{ number_format($prestamo->total, 2, '.', ',') }} MXN</td>
                          @endif
                          <td>${{ number_format($prestamo->pendiente, 2, '.', ',') }} MXN</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="2">Sin registros.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                    <div class="table-responsive">
                      <table>
                        <tr>
                          <td><b>Total de descuentos:</b> ${{ number_format($totalDescuentos, 2, '.', ',') }} MXN</td>
                        </tr>
                        <tr>
                          <td><b>Total de prestamo:</b> ${{ number_format($totalPrestamos, 2, '.', ',') }} MXN</td>
                        </tr>
                        <tr>
                          <td><b>Deuda total</b> ${{ number_format($totalPrestamos -$totalDescuentos , 2, '.', ',') }} MXN</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card-footer mr-auto">
                  <div class="card-footer mr-auto">
                    {{ $prestamos->links() }}
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
