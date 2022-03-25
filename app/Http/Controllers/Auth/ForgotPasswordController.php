<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Mail\resetEmail as resetEmail;

class ForgotPasswordController extends Controller
{
// $user->notify(new ResetPasswordNotification($invoice));

    /*}
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
use SendsPasswordResetEmails;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function sendResetLinkEmail(Request $request)
    {
       

        $this->validate($request, ['email' => 'required']);
         // $this->validateEmail($request);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $email2=$request->email;
        if (!(str_contains($email2,'@'))){
            $response1=DB::table('jugador')
            ->join('encargados','encargados.idPlayer','=','jugador.idPlayer')
            ->select('encargados.email','encargados.name')
            ->where('code','=',$email2)
            ->first();
            if((isset($response1))){
                
                $nombres = array('email' => $response1->email,'name'=>$response1->name);
            }else {
                $error ='Codigo incorrecto';
                return back()->withErrors($error);
            }
        }else{
            $nombres = array('email' => $email2,'name'=>'Humano');
            $respuesta=DB::table('users')
            ->select('email')
            ->where('email','=',$request->email)
            ->first();
            if(!(isset($respuesta))||$respuesta ==" "){
            $error ='Correo electronico incorrecto';
            return back()->withErrors($error);
        }

        }
        $tokens=Helpers::tokens(35);
        $date1=Carbon::now();
            //Se verifica de dos maneras para saber si es un Jugador o un entrenador (admin)
  
                $respuesta2= DB::table('password_resets')
                            ->select('email_code')
                            ->where('email_code','=',$nombres['email'])
                            ->first();
         
            //Se borra si hay respuesta (osea si ya existe)
              
            if((isset($respuesta2))||$respuesta2 !=" "){   
                    if($nombres['email']==$email2){
                            DB::table('password_resets')
                             ->where('email_code','=',$nombres['email'])
                             ->delete();                    
                            }else{
                            DB::table('password_resets')
                             ->where('email_code','=',$email2)
                             ->delete();                    }
            }
    
        
                    $tokensEn = encrypt($tokens);
                    if($nombres['email']==$email2){
                        $values = array('email_code' => $nombres['email'],'token' => $tokensEn,'created_at' => $date1);
                    }else{
                        $values = array('email_code'=>$email2,'token' => $tokensEn,'created_at' => $date1);
                    }
                    //Se llena la tabla de password_resets
                    DB::table('password_resets')->insert($values);

        
        $url = route('password.reset',$tokens);
        $user = new \App\User([
            'email'=>$nombres['email'],
            'name'=>$nombres['name'],
            'ruta'=>$url,
        ]);
      Mail::to($user->email,$user->name)
            ->send(new resetEmail($user));
        return redirect()->route('index');
  }
    public function __construct()
    {
        $this->middleware('guest');
    }

    //  public function showLinkRequestForm()
    //  {
    //   return view('passwords.email');
    //  }
}
