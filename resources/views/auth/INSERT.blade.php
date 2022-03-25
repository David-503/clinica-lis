
@extends('layouts.master')

@section('ClassBody','login-page sidebar-collapse')
@section('header')
<div class="page-header header-filter rose-filter" style="background-image: url('/img/bg-1.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
          <div class="card card-login">
            
          <form class="form" style="min-height: auto;" method="POST" action="{{route('setPassword')}}">
            <input type="hidden" value="{{$email}}" name="email">
            <input type="hidden" value="{{$token}}" name="token">
            
                @csrf
                <div class="card-header card-header-rose text-center">
                    <h4 class="card-title">Completar registro</h4>
                </div>
                <p class="description text-center">Completar los campos para completar el registro:</p>
                <div class="card-body">
                    <div class="input-group d-flex flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                            </span>
                        </div>
                        <div class="form-group mb-0 w-100 {{$errors->has('password') ? 'has-danger' : '' }}">
                            <input type="password" class="form-control" name="password" required autofocus placeholder="Contraseña...">
                            <span style="top:0px;" class="material-icons {{$errors->any() ? 'd-block' : 'd-none'}} form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">lock_outline</i>
                        </span>
                        </div>
                        <input id="password_confirmation" type="password" class="form-control{{ $errors->any() ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="Confirmacion de contraseña..." required>
                        <span class="invalid-feedback" role="alert">
                        @foreach ($errors->all() as $error)
                        <strong>{{ $error}}</strong>
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="footer text-center" style="position: relative">
                    <button type="submit" class="btn btn-rose btn-link btn-wd btn-lg">Completar registro</button>
                </div>
                    
            </form>
          </div>
        </div>
      </div>
    </div>
</div>


@endsection

@section('MainContent')
@endsection

