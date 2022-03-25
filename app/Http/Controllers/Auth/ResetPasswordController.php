<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use password;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Helpers\Helpers;
use App\User;
class ResetPasswordController extends Controller
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
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function guard(){
        return Auth::guard('users');
    }
    protected function broker(){
        return Password::broker('users');
    }

    public function insertPassword(Request $request)
{
    $PASSWORD=$request->password;
    $PASSWORDCONFI=$request->password_confirmation;
    if (($request->password) == ($request->password_confirmation))
    {
      
                if (!(mb_strlen($PASSWORD) <6 ) ||  !(mb_strlen($PASSWORDCONFI)<6))
                        {
                                    $DBtoken=DB::table('password_resets')
                                            ->select('token','created_at','email')
                                            ->where( 'email','=',$request->email)
                                            ->first();
                                    if(!(isset($DBtoken))||$DBtoken ==" "){
                                        $error ='Ruta corrupta';
                                        return back()->withErrors($error);
                                    }
                                    if (($DBtoken->token == $request->token)) 
                                    {

                                                $PasswordHash = Hash::make($PASSWORDCONFI);
                                                
                                                //Se actualiza la tabla user    
                                                User::where('email','=',$request->email)
                                                ->update(['password'=>$PasswordHash]);
                                                
                                                //Se borra el registro de reseteos
                                                DB::table('password_resets')
                                                ->where('email','=',$request->email)
                                                ->delete();
                                                return redirect()->route('login');

                                    }else{
                                    $error = "Token invalido";
                                    return back()->withErrors($error);
                                    }
                        }else{
                        $error = "Ingrese una contraseña mayor a 6 digitos";
                        return back()->withErrors($error);
                        }
    }else{
        $error = "Los campos del password deben ser iguales";
        return back()->withErrors($error);
        }
}
    // public function showResetForm(Request $request, $token = null)
    // {
    //         return view('auth.passwords.reset')->with(
    //             ['token' => $token, 'email' => $request->email]
    //         );
    // }
    public function showInsertForm(Request $request,$token = null, $email = null)
    {   
            return view('auth.INSERT')->with(
                ['token' => $token, 'email' => $email]
            );;

            // return view('auth.passwords.insert')->with(
            //     ['token' => $token, 'email' => $request->email]
            // );
    }
}