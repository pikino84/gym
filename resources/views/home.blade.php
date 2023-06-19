@extends('layouts.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!--Enter code here -->
            <p>Bienvenido: <b>{{ Auth::user()->name }}</b></p>
        </div>
    </div>
</div>
@endsection
