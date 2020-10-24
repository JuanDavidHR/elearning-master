@extends('auth.inicioSesion')
@section('login')
<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card-group mb-0">
        <div class="card p-4">
        <form class="form-horizontal was-validated" method="POST" action="{{route('login')}}">
            {{ csrf_field() }}
            <div class="card-body">
                <h1>Acceder</h1>
                <p class="text-muted">Control de acceso al sistema</p>
                <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="feather icon-user-check" style="font-size: 20px; display:block; background:white;"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                {!!$errors->first('usuario', '<small class="text-danger">:message</small>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="feather icon-unlock" style="font-size: 20px; display:block; background:white;"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="on">
                {!!$errors->first('password', '<small class="text-danger">:message</small>')!!}
                </div>
                <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary px-4">Acceder</button>
                </div>
                </div>
            </div>
        </form>
        </div>
        <div class="card text-white bg-success py-5 d-md-down-none" style="width:44%;">
        <div class="card-body text-center d-flex justify-content-center align-items-center flex-column">
            <h1 style="font-weight: 900;">Sistema Café</h1>
            <p style="font-weight: bold; font-size: 18px;">Sistema desarrollado y diseñado exclusivamente para KAPHIY PIRUW</p>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
