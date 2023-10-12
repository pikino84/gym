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
                        <th>Fecha</th>
                        <th>Semana</th>
                        <th>Serie</th>
                        <th>Folio</th>
                        <th>Concepto</th>
                        <th>Importe</th>
                        <th>IVA</th>
                        <th>Total</th>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer mr-auto">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
