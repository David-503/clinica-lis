<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use Illuminate\Support\Facades\Auth;

class notificationController extends Controller
{
    public function listaNotificaciones(Request $request){
        $notificaciones = Notifications::with('user')->where('id_user',Auth::user()->dui)->orderBy('id','asc')->take(5)->get();
        return $notificaciones;
    }

    public function vistoNotificaciones(Request $request){
        $notificacion = Notifications::find($request->id);
        $notificacion->status = 0;
        $notificacion->save();
        return 'Exito';
    }
}
