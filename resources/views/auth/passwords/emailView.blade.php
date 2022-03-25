@component('mail::message')
# Hola {{$user->name}}
 
Bienvenido al sitio web Clinica las Palmas, para completar su registro es necesario ingresar una contraseña a su nueva cuenta, por favor siga el siguiente link para completar su registro:

@component('mail::button', ['url' => ''. $user->address ,'color' => 'green'])
Acceder al link
@endcomponent
Acceder al link lo antes posible

Si usted no realizo la petición por favor hacer caso omiso.

¡Saludos!!!,<br>
{{ config('app.name') }}
@component('mail::panel')
Si no puede acceder al link anterior haga click aqui:
{{$user->address}}
@endcomponent
@endcomponent
