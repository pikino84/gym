@extends('layouts.main', ['activePage' => 'invoices', 'titlePage' => 'Detalles de la factura'])
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <!--Header-->
          <div class="card-header card-header-primary">
            <h4 class="card-title">Factura</h4>
            <p class="card-category">Vista detallada de la factura {{ $invoice->id_invoice }}</p>
          </div>
          <!--End header-->
          <!--Body-->
          <div class="card-body">
            <div class="row">
              <!-- first -->
              <div class="col-md-4">
                <div class="card card-user">
                  <div class="card-body">
                    <p class="card-text">
                      <div class="author">
                        <div class="block block-one"></div>
                        <div class="block block-two"></div>
                        <div class="block block-three"></div>
                        <div class="block block-four"></div>
                        
                          <h5 class="title mt-3"><b>Numero de orden:</b> {{ $invoice->id_invoice }}</h5>
                          <p class="description"><strong>Descricón:</strong> {{ $invoice->description }}</p>
                          <p class="description"><strong>Monto:</strong> {{ $invoice->monto }}</p>
                  
                      </div>
                    </p>
                  </div>
                  <div class="card-footer">
                    <div class="button-container">
                      <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">Editar</a>
                      <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-warning">Volver</a>
                    </div>
                  </div>
                </div>
              </div>
              <!--end first-->
            </div>
            <!--end row-->
          </div>
          <!--End card body-->
        </div>
        <!--End card-->
      </div>
    </div>
  </div>
</div>
@endsection