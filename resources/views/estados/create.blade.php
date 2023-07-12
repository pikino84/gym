@extends('layouts.main', ['activePage' => 'deudas', 'titlePage' => 'Nueva deuda'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" action="{{ route('deudas.store') }}" class="form-horizontal">
          @csrf
          <div class="card ">
            <!--Header-->
            <div class="card-header card-header-primary">
              <h4 class="card-title">Deuda</h4>
              <p class="card-category">Ingresar datos de la deuda</p>
            </div>
            <!--End header-->
            <!--Body-->
            <div class="card-body">
              <div class="row">
                <label for="title" class="col-sm-2 col-form-label">Número de deuda</label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="title" placeholder="Inresar número de documento"
                    autocomplete="off" autofocus>
                </div>
              </div>
            </div>

            <!--End body-->

            <!--Footer-->
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">Guardar</button>
              <a href="{{ route('deudas.index') }}" class="btn btn-primary btn-warning">Volver</a>
            </div>
            <!--End footer-->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection