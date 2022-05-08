<?php

namespace App\Http\Controllers;
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
use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Validator;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;
class pacienteController extends Controller
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
            //Agregando validacion del formato del dui, correo elextronico y telefono
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
            $patient = new User;
            $patient->dui = $request->dui;
            $patient->name = $request->name;
            $patient->lastname = $request->lastname;
            $patient->email = $request->email;
            $patient->address = $request->address;
            $patient->gender = 0;
            $patient->password = bcrypt("12345678");
            $patient->birthdate = $date;
            $patient->id_type_user = 5;
            $patient->save();
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
            return response('Paciente agregado con exito, correo enviado con exito.',200);
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

            $patient = User::find($request->dui);
            $patient->name = $request->name;
            $patient->lastname = $request->lastname;
            $patient->email = $request->email;
            $patient->address = $request->address;
            $patient->save();
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
            return response('Paciente modificado con exito.',200);
        }catch(QueryException $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);

        }
    }

    public function listarPacientes (Request $request){
       try{
            $pacientes= User::with('phones')->where('id_type_user',5)->get();
            if($pacientes == null){
                return response("No se han encontrado pacientes",500);
            }
            return response($pacientes,200);

       }catch(QueryExeption $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);

       }

    }
    public function infoPaciente (Request $request){
        try{
            if(!$request->filled('dui'))
                return response('Se necesita la clave primaria',400);

            $validator= Validator::make($request->all(),['dui' => 'required|regex:/^[0-9]{8}-[0-9]$/']);
            if ($validator->fails()) 
                return response('Error de validacion: ' . $validator->messages()->first(),400);
            
            $pacientes= User::with('phones')->where('id_type_user',5)->where('dui',$request->dui)->first();
            if($pacientes == null)
                return response("No se ha encontrado el paciente:" . $request->dui ,500);
            
         
            return response($pacientes,200);
 
        }catch(QueryExeption $ex){
            return response('Ocurrio algun error: '. $ex->getMessage() ,400);
        }
 
    }
    public function listarPost (Request $request){
        $patients = User::where('id_type_user',5)->get(['dui','name']);
        return $patients;
    }
    public function delete ($dui = null){
        
        $paciente = User::find($dui);
        if($paciente == null){
            return response('No se encuentra el usuario que se desea borrar',400);
        }
        //Borrar citas
        $deletedMedicalAppointment = MedicalAppointment::where('id_patient', $dui)->delete();
        //Borrar telefonos
        $deletePhones = Phone::where('id_usuario', $dui)->delete();
        //Borrar preescripciones
        $deletePreescription = Prescription::where('id_patient', $dui)->delete();
        //Buscar en la tabla patient
        $patient = Patient::find($dui);
        //Si existe el id del documento
        if($patient != null){
            if($patient->id_file != null){
                //Se busca en la tabla documento
                $files= File::find($patient->id_file);
                //Se borra la informacion general
                InformationDataFile::destroy($files->id_information_file );
                //Se borra la informacion de identificacion
                IdentificationFile::destroy($files->id_identification_file );
                //Se borra el file
                $files->delete();
                //Se borra los registros de monitoreo medico
                $deleteMonitoring = Phone::where('id_patient ', $patient->id_patient)->delete();
                //Se borra el patient
                $patient->delete();
            }
        }

        $paciente->delete(); //Se borra el usuario

        return response('El paciente fue eliminado con exito.', 200);

    }
}
