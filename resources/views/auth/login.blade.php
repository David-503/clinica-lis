
@extends('layouts.master')

@section('ClassBody','login-page sidebar-collapse')
@section('header')
<div class="page-header header-filter rose-filter" style="background-image: url('../img/bg-1.jpg'); background-size: cover; background-position: top center;">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 ml-auto mr-auto">
          <div class="card card-login">
            
            <form class="form" style="min-height: auto;" method="POST" action="">
                @csrf
                <div class="card-header card-header-rose text-center">
                    <h4 class="card-title">Login</h4>
                </div>
                <p class="description text-center">Ingresar credenciales:</p>
                <div class="card-body">
                    <div class="input-group d-flex flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="material-icons">email</i>
                            </span>
                        </div>
                        <div class="form-group mb-0 w-100 {{$errors->has('email') ? 'has-danger' : '' }}">
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo Electrónico...">
                            <span style="top:0px;" class="material-icons {{$errors->has('email') ? 'd-block' : 'd-none'}} form-control-feedback">clear</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">lock_outline</i>
                        </span>
                        </div>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password..." required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="footer text-center" style="position: relative">
                    <button type="submit" class="btn btn-rose btn-link btn-wd btn-lg">Iniciar</button>
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
@section('scripts')
   <script type="text/javascript">
       sessionStorage.clear();
   </script>
@endsection

