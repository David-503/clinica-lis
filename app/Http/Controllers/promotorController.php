<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Phone;
use App\MedicalAppointment;
use App\InformationDataFile;
use App\IdentificationFile;
use App\MedicalMonitoring;
use App\Prescription;
use App\File;
use App\Patient;
use App\Helpers\Helpers;
use App\Exceptions\Handler;
use Validator;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;

class promotorController extends Controller
{
    public function crearPost (Request $request){
        try{
            
            if(!($request->filled(['dui', 'name', 'lastname', 'email', 'address','birthdate']))){
                return response('Datos incompletos',400);
            }
            //No se si sera necesario pero le quita a la fecha todo lo que esta despues de la T 
            $date = "";
            $date2 =$request->birthdate;
            for ($i=0; $i < strlen($date2) ; $i++) { 
                if(!(strcmp($date2[$i], 'T')==0)){
                $date = $date. $date2[$i];
                }else{ $i =strlen($date2);  }
            }
            $validator= Validator::make($request->all(),[
                'dui' => 'required|regex:/^[0-9]{8}-[0-9]$/',
                'phone' => 'max:9|regex:/^[762][0-9]{3}-[0-9]{4}$/',
                'name' => 'max:50',
                'lastname' => 'max:50',
                'email' => 'max:191',
                'address' => 'max:150'
            ]);
            if ($validator->fails()) {
                return response('Error de validacion: ' . $validator->messages()->first(),400);

            }
            if(User::find($request->dui)!=null){
                return response('El dui ingresado ya existe en nuestros registros',400);
            }
            if(User::where('email',$request->email)->first()!=null){
                return response('El correo ingresado ya existe en nuestros registros',400);
            }
            $promotor = new User;
            $promotor->dui = $request->dui;
            $promotor->name = $request->name;
            $promotor->lastname = $request->lastname;
            $promotor->email = $request->email;
            $promotor->address = $request->address;
            $promotor->gender = 0;
            $promotor->password = bcrypt("12345678");
            $promotor->birthdate = $date;
            $promotor->id_type_user = 3;
            $promotor->save();
            if(Helpers::sendPassword($request->dui) == 0){
                $user = User::find($request->dui);
                $user->delete();
                return response('No se puede enviar correo de confirmacion.',500);
            }

            if($request->filled('phone')){
                $phone = new Phone;
                $phone->phone = $request->phone;
                $phone->type = 'Tel';
                $phone->id_usuario = $request->dui;
                $phone->save();
            }
            return response('Promotor agregado con exito, correo enviado con exito.',200);
        }catch(QueryException $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);

        }
    }

    public function actualizarPost (Request $request){
        try{
            
            if(!($request->filled(['name', 'lastname', 'email', 'address']))){
                return response('Datos incompletos',400);
            }

            $validator= Validator::make($request->all(),[
                'dui' => 'required|regex:/^[0-9]{8}-[0-9]$/',
                'phone' => 'max:9|regex:/^[762][0-9]{3}-[0-9]{4}$/',
                'name' => 'max:50',
                'lastname' => 'max:50',
                'email' => 'max:191',
                'address' => 'max:150'
            ]);
            if ($validator->fails()) {
                return response('Error de validacion: ' . $validator->messages()->first(),400);

            }

            $promotor = User::find($request->dui);
            $promotor->name = $request->name;
            $promotor->lastname = $request->lastname;
            $promotor->email = $request->email;
            $promotor->address = $request->address;
            $promotor->save();
            if($request->filled('phone')){
                $oldPhone =Phone::where('phone',$request->phone)->first();
                if( $oldPhone == null){
                $phone = new Phone;
                $phone->phone = $request->phone;
                $phone->type = 'Tel';
                $phone->id_usuario = $request->dui;
                $phone->save();
                }else{
                    $oldPhone->phone = $request->phone;
                    $oldPhone ->save();
                }
            }
            return response('Promotor modificado con exito.',200);
        }catch(QueryException $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);

        }
    }
    public function listarPromotores(Request $request){
        try{
             $Promotores= User::with('phones')->where('id_type_user',3)->get();
             if($Promotores == null){
                 return response("No se han encontrado Promotores",500);
             }
             return response($Promotores,200);
 
        }catch(QueryExeption $ex){
             return response('Ocurrio algun error: '. $ex->getMessage() ,400);
 
        }
 
     }

    public function infoPromotor (Request $request){
        try{
            if(!$request->filled('dui'))
                return response('Se necesita la clave primaria',400);
            $validator= Validator::make($request->all(),['dui' => 'required|regex:/^[0-9]{8}-[0-9]$/']);
            if ($validator->fails()) 
                return response('Error de validacion: ' . $validator->messages()->first(),400);
            
            $Promotor= User::with('phones')->where('id_type_user',3)->where('dui',$request->dui)->first();
            if($Promotor == null)
                return response("No se ha encontrado el promotor:" . $request->dui ,500);
            
                
            return response($Promotor,200);
 
        }catch(QueryExeption $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);
        }
 
    }
    public function delete ($dui = null){
        
        $Promo = User::find($dui);
        if($Promo == null){
            return response('No se encuentra el usuario que se desea borrar',400);
        }

        //Borrar telefonos
        $deletePhones = Phone::where('id_usuario', $dui)->delete();
        $Promo->delete(); //Se borra el usuario
        return response('El promotor fue eliminado con exito.', 200);


    }
}
