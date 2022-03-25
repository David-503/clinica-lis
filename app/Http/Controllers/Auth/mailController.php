<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Providers\Illuminate\Support\Facades\View;
use App\Http\Controllers\Auth\URL;
use App\Http\Controllers\Controller;
use Mail;
use Session; 
use redirect;
use Input;
use Illuminate\Http\Request;

class mailController extends Controller
{
     
    public function mailInter(Request $request){


}

    public function mail(Request $request){
        //Extrea los valores del input
        $Nombre= $request->input('value0');
        $Correo= $request->input('value1');
        $Mensaje= $request->input('value2');
        //Retorna una variable comun a todas las vistas 
        view()->share('Nombre',$Nombre);
        view()->share('Correo',$Correo);
        view()->share('Mensaje',$Mensaje);

        Mail::send('emails.contact',$request->all(),function($msj){
            $msj->subject('Correo de contacto');
            $msj->to('keepeer.sv@gmail.com');//Adonde sera enviado este correo
            //$msj->to('cruzt6869@gmail.com');//Correo de tito 
        });
        
        Session::flash('flash_message','Mensaje enviado correctamente');
        //return view('emails.contact');// VISTA DEL LUGAR DONDE SE  HACE EL CUERPO DEL CORREO
    
        //Redirecciona a una ruta
        return redirect()->route('print');
    }

}