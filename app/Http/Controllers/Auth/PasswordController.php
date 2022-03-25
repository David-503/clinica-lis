<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Session; 
use redirect;
use Input;
use User;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    protected $redirectTo = '/';
    protected function resetPassword($user, $password){
            $user->password = $password;
            $user->save();
            Auth::login($user);
    }
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function getEmail(){
    return view('passwords.email2');
    }




    public function postEmail(Request $request){
        $_token = $request->input('_token');
    $email = $request->input('email');

    view('passwords.password')->with($_token,$_token);

        Mail::send('passwords.password',$request->all(),function($msj) use ($email) 
        {          
        $msj->from('keepeer.sv@gmail.com','KeePeer el Salvador');
        $msj->subject('Correo de recuperación de contraseña');
        $msj->priority('ALTA');
        $msj->to($email)->bcc('keepeer.sv@gmail.com');   //Adonde sera enviado este correo
                //$msj->to('cruzt6869@gmail.com');//Correo de tito 
        });
        }




        
}
