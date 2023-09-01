@extends('layouts.main', ['activePage' => 'financiamientos', 'titlePage' => 'Financiamientos'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">Financiamientos</h4>
                  <p class="card-category">Reporte de financiamientos</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Prestamos</th>
                        <th>Descuentos</th>
                        <th>Total deuda</th>
                      </thead>
                      <tbody>
                        @forelse ($financiamientos as $financiamiento)
                        <tr>
                          <td>{{ $financiamiento->id }}</td>
                          <td>{{ date('Y-m-d', strtotime($financiamiento->fecha)) }}</td>
                          <td>{{ $financiamiento->serie }}</td>
                          <td>{{ $financiamiento->folio }}</td>
                          <td>{{ $financiamiento->prestamos }}</td>
                          <td>{{ $financiamiento->descuentos }}</td>
                          <td>{{ $financiamiento->deuda_total }}</td>
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
                  {{ $financiamientos->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
