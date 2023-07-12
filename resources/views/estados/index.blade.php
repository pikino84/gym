@extends('layouts.main', ['activePage' => 'deudas', 'titlePage' => 'Mis deudas'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Mis Deudas</h4>
            <p class="card-category">Lista de deudas registradas por: NOMBRE DEL PROVEEDOR </p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 text-right">
                @can('deuda_create')
                <a href="{{ route('deudas.create') }}" class="btn btn-sm btn-facebook">Añadir Deuda</a>
                @endcan
              </div>
            </div>
            <div class="table-responsive">
              <table class="table ">
                <thead class="text-primary">
                  <th> ID </th>
                  <th> Número de deuda </th>
                  <th> Documento </th>
                  <th class="text-right"> Acciones </th>
                </thead>
                <tbody>
                  @forelse ($deudas as $deuda)
                  <tr>
                    <td>{{ $deuda->id }}</td>
                    <td>{{ $deuda->title }}</td>
                    <td class="text-primary">{{ $deuda->created_at->toFormattedDateString() }}</td>
                    <td class="td-actions text-right">
                    @can('deuda_show')
                      <a href="{{ route('deuda.show', $deuda->id) }}" class="btn btn-info"> <i
                          class="material-icons">person</i> </a>
                    @endcan
                    @can('deuda_edit')
                      <a href="{{ route('deuda.edit', $deuda->id) }}" class="btn btn-success"> <i
                          class="material-icons">edit</i> </a>
                    @endcan
                    @can('deuda_destroy')
                      <form action="{{ route('deuda.destroy', $deuda->id) }}" method="post"
                        onsubmit="return confirm('areYouSure')" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" rel="tooltip" class="btn btn-danger">
                          <i class="material-icons">close</i>
                        </button>
                      </form>
                      @endcan
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="2">Sin deudas.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
              {{-- {{ $users->links() }} --}}
            </div>
          </div>
          <!--Footer-->
          <div class="card-footer mr-auto">
            {{ $deudas->links() }}
          </div>
          <!--End footer-->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
