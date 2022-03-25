<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB; 
use Auth;
use App\User;
use App\Mail\sendPassword;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use \Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;

class Helpers {
    //Esta funcion tiene como objetivo enviar un correo electronico 
    //con los datos pertinenetes para que el usuario pueda registrar una contraseña
    public static function sendPassword($DUI){
        try{

            $user = User::find($DUI);
            if($user == null){
                return 0;
            }

        
        $tokens=Helpers::tokens(35);
        $date1=Carbon::now();
            //Se verifica de dos maneras para saber si es un Jugador o un entrenador (admin)
  
                $respuesta2= DB::table('password_resets')
                            ->select('email')
                            ->where('email','=',$user->email)
                            ->first();
         
            //Se borra si hay respuesta (osea si ya existe)
              
            if((isset($respuesta2))||$respuesta2 !=" "){   
                            DB::table('password_resets')
                             ->where('email','=',$user->email)
                             ->delete();  }
            
                        $values = array('email'=>$user->email,'token' => $tokens,'created_at' => $date1);
                    
                    //Se llena la tabla de password_resets
                    DB::table('password_resets')->insert($values);
        
		$url = route('insertPassword',['token'=> $tokens,'email' =>$user->email]);
        $user2 = new \App\User([
			'address'=>$url,
            'email'=>$user->email,
            'name'=>$user->name
			]);
            Mail::to($user2->email)
            ->send(new sendPassword($user2));
        return 1;
        }catch(Swift_TransportException $ex){
            if(User::find($user->dui) !=null){
            $user = User::find($request->dui);
            $user->delete();}
            return 0;
        }
    } 


	//Esta funcion devuelve la fecha en formato carbon para su utilizacion, 
	//Como datos de entrada tiene que estar un string con la fecha
	//y true o false dependiendo si se ingresa con hora o no
	public static function fechaCarbon($DBfecha,$onlyDate){
		if($onlyDate){
				$create=$DBfecha;
            	$fecha=explode('-',$create);
				$dateCarbon = Carbon::parse($fecha[0], $fecha[1], $fecha[2]);
				return ($dateCarbon);
		}else{
		
				$dateCarbon=Carbon::parse($DBfecha);
				return ($dateCarbon);
		}
	}
	//Creación de un token o contraseña al azar
	//Recive el numero de digitos que tendra, 
	//NOTA SE MULTIPLICA POR 2 ESTE VALOR
	public static function tokens($iterador){
		$letras = array('A', 'B', 'C', 'D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','Z','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		$num= array('0','1','2','3','4','5','6','7','8','9');
		$tokens='';
		for ($i=0; $i <$iterador ; $i++) { 
			$tokens .= $letras[rand(0, 51)];
			$tokens .= $num[rand(0,9)];
		}
	return $tokens;
	}
 

	public static function today(){
		$today = Carbon::now(); 
		$hoy = $today->dayOfWeek;
		
		return $hoy;
	}

	public static function hour(){
		$hora = Carbon::now(); 
		$hour = $hora->hour;
		
		return $hour;
	}


	public static function age($birthday){
		$year = Carbon::now();
		$year = $year->year;

		$month = Carbon::now();
		$month = $month->month;

		$day = Carbon::now();
		$day = $day->day;

		$bdYear = substr($birthday,0,4);
		$bdMonth = substr($birthday,5,2);
		$bdDay = substr($birthday,8,2);

		$age = (($year - $bdYear) - 1);

		if ($month > $bdMonth){
			$age += 1;
		}elseif($month == $bdMonth){
			if ($day >= $bdDay){
				$age += 1;
			}
		}

		return $age;
	}



	public static function formatDate($date){
		$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

		$mes = substr($date,5,2);
		$año = substr($date,2,2);
		$date = $meses[$mes-1].'-'.$año;

		return $date;
	}
}