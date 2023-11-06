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
                            <td>${{ number_format($prestamo->total, 2, '.', ',') }} {{ ($prestamo->moneda == 1?' MXN':' USD') }}</td>
                            <td></td>
                          @else
                            <td></td>
                            <td>${{ number_format($prestamo->total, 2, '.', ',') }} {{ ($prestamo->moneda == 1?' MXN':' USD') }}</td>
                          @endif
                          <td>${{ number_format($prestamo->pendiente, 2, '.', ',') }} {{ ($prestamo->moneda == 1?' MXN':' USD') }}</td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="2">Sin registros.</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  @php
                    $descuentosMXN = 0;
                    $prestamosMXN = 0;
                    $descuentosUSD = 0;
                    $prestamosUSD = 0;
                  @endphp
                  @forelse ($montos as $monto)
                    @if ($monto->naturaleza == 0)
                      @if ($monto->moneda == 1)
                        @php
                          $prestamosMXN += $monto->total;
                        @endphp                        
                      @elseif ($monto->moneda == 2)
                        @php
                          $prestamosUSD += $monto->total;
                        @endphp
                      @endif
                    @elseif ($monto->naturaleza == 1)
                      @if ($monto->moneda == 1)
                        @php
                          $descuentosMXN += $monto->total;
                        @endphp                        
                      @elseif ($monto->moneda == 2)
                        @php
                          $descuentosUSD += $monto->total;
                        @endphp
                      @endif
                    @endif
                  @empty
                    
                  @endforelse
                  <div class="table-responsive">
                    <table>
                      <tbody>
                        <tr>
                          <td>
                            <table>
                              <tbody>
                                <tr>
                                  <td><b>Total de prestamos:</b> ${{ number_format($prestamosMXN, 2, '.', ',') }} MXN</td>
                                </tr>
                                <tr>
                                  <td><b>Total de descuentos:</b> ${{ number_format($descuentosMXN , 2, '.', ',') }} MXN</td>
                                </tr>
                                <tr>
                                  <td><b>Deuda Total: </b>${{ number_format($prestamosMXN - $descuentosMXN , 2, '.', ',') }} MXN</td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                          <td>
                            <table>
                              <tbody>
                                <tr>
                                  <td><b>Total de prestamos:</b> ${{ number_format($prestamosUSD, 2, '.', ',') }} USD</td>
                                </tr>
                                <tr>
                                  <td><b>Total de descuentos:</b> ${{ number_format($descuentosUSD , 2, '.', ',') }} USD</td>
                                </tr>
                                <tr>
                                  <td><b>Deuda Total: </b>${{ number_format($prestamosUSD - $descuentosUSD , 2, '.', ',') }} USD</td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
