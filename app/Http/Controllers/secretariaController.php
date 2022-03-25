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

class secretariaController extends Controller
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
            $secretary = new User;
            $secretary->dui = $request->dui;
            $secretary->name = $request->name;
            $secretary->lastname = $request->lastname;
            $secretary->email = $request->email;
            $secretary->address = $request->address;
            $secretary->gender = 0;
            $secretary->password = bcrypt("12345678");
            $secretary->birthdate = $date;
            $secretary->id_type_user = 4;
            $secretary->save();
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
            return response('Secretaria agregada con exito, correo enviado con exito.',200);
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

            $secretary = User::find($request->dui);
            $secretary->name = $request->name;
            $secretary->lastname = $request->lastname;
            $secretary->email = $request->email;
            $secretary->address = $request->address;
            $secretary->save();
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
            return response('Secretaria modificado con exito.',200);
        }catch(QueryException $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);

        }
    }
    public function listarSecretarias (Request $request){
        try{
             $Secretarias= User::with('phones')->where('id_type_user',4)->get();
             if($Secretarias == null){
                 return response("No se han encontrado Secretarias",500);
             }
             return response($Secretarias,200);
 
        }catch(QueryExeption $ex){
             return response('Ocurrio algun error: '. $ex->getMessage() ,400);
 
        }
 
     }

    public function infoSecretaria (Request $request){
        try{
            if(!$request->filled('dui'))
                return response('Se necesita la clave primaria',400);
            $validator= Validator::make($request->all(),['dui' => 'required|regex:/^[0-9]{8}-[0-9]$/']);
            if ($validator->fails()) 
                return response('Error de validacion: ' . $validator->messages()->first(),400);
            
            $Secretaria= User::with('phones')->where('id_type_user',4)->where('dui',$request->dui)->first();
            if($Secretaria == null)
                return response("No se ha encontrado la secretaria:" . $request->dui ,500);
            
                
            return response($Secretaria,200);
 
        }catch(QueryExeption $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);
        }
 
    }
    public function delete ($dui = null){
        
        $Secreta = User::find($dui);
        if($Secreta == null){
            return response('No se encuentra el usuario que se desea borrar',400);
        }

        //Borrar telefonos
        $deletePhones = Phone::where('id_usuario', $dui)->delete();
        $Secreta->delete(); //Se borra el usuario
        return response('La secretaria fue eliminado con exito.', 200);


    }

}
