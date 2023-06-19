@extends('layouts.main', ['activePage' => 'invoices', 'titlePage' => 'Facturas'])
@section('content')
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-primary">
                    <h4 class="card-title">Facturas</h4>
                    <p class="card-category">Facturas registradas</p>
                  </div>
                  <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success" role="success">
                      {{ session('success') }}
                    </div>
                    @endif
                    <div class="row">
                      <div class="col-12 text-right">
                        @can('invoice_create')
                        <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-facebook">Añadir Factura</a>
                        @endcan
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          <th>#</th>
                          <th>ID factura</th>
                          <th>Proveedor</th>
                          <th>Descripción</th>
                          <th>Monto</th>
                          <th>Estatus</th>
                          <th class="text-right">Acciones</th>
                        </thead>
                        <tbody>
                          @foreach ($invoices as $invoice)
                            <tr>
                              <td>{{ $invoices->id_invoce }}</td>
                              <td>{{ $invoices->razonsocila }}</td>
                              <td>{{ $invoices->description }}</td>
                              <td>{{ $invoices->id_status }}</td>
                              <td>
                                  @forelse ($user->roles as $role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                  @empty
                                    <span class="badge badge-danger">No roles</span>
                                  @endforelse
                                </td>
                              <td class="td-actions text-right">
                                @if ($user->id != 1 OR auth()->user()->id == 1  )
                                  @can('user_show')
                                  <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info"><i class="material-icons">person</i></a>
                                  @endcan
                                  @can('user_edit')  
                                  <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                  @endcan
                                  @can('user_destroy')
                                  <form action="{{ route('invoices.delete', $invoice->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Seguro?')">
                                  @csrf
                                  @method('DELETE')
                                      <button class="btn btn-danger" type="submit" rel="tooltip">
                                      <i class="material-icons">close</i>
                                      </button>
                                  </form>
                                  @endcan
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer mr-auto">
                    {{ $invoices->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
