@extends('layouts.main', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Booking')])

@section('content')
<div class="container" style="height: auto;">
    <div class="row align-items-center">
        <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
            <img src="{{ asset('img/logo_bco.png') }}" alt="">
        </div>
        <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card card-login card-hidden mb-3">
                    <div class="card-body">
                        {{-- Username --}}
                        <div class="bmd-form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">face</i>
                                    </span>
                                </div>
                                <input type="text" name="username" class="form-control" placeholder="{{ __('Usuario o Correo ...') }}"
                                    value="{{ old('username', null) }}" required autocomplete="username" autofocus>
                            </div>
                            @if ($errors->has('username'))
                            <div id="username-error" class="error text-danger pl-3" for="username" style="display: block;">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('Contraseña...') }}" required autocomplete="current-password">
                            </div>
                            @if ($errors->has('password'))
                            <div id="password-error" class="error text-danger pl-3" for="password"
                                style="display: block;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}> {{ __('Recurda me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Entrar') }}</button>
                    </div>
                </div>
            </form>
            {{-- 
            <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
                        <small>{{ __('Forgot password?') }}</small>
                    </a>
                    @endif
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('register') }}" class="text-light">
                        <small>{{ __('Create new account') }}</small>
                    </a>
                </div>
            </div>
             --}}
        </div>
    </div>
</div>
<div class="float-button" onclick="sendMessage()">
    <svg viewBox="0 0 32 32" style="width: 100%; height: 100%; fill: rgb(255, 255, 255); stroke: none;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z"></path></svg>
</div>
@endsection
<script>
    function sendMessage() {
        var phoneNumber = "5213320573051"; // Reemplaza con el número de teléfono al que deseas enviar el mensaje
        var message = "¡Hola! Perdi mi contrasña"; // Reemplaza con el mensaje que deseas enviar

        var whatsappUrl = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(message);
        window.open(whatsappUrl, "_blank");
    }
</script>