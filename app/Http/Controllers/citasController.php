<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MedicalAppointment;
use Validator;
use App\Notifications;
use App\User;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\QueryException;

class citasController extends Controller
{
    public function crearPost(Request $request)
    {
        try {
            if (!($request->filled(['Date', 'SelectedPatientDui', 'SelectedDoctorDui', 'InitialHour', 'FinalHour']))) {
                return response('Datos incompletos', 400);
            }
            //Agregando validacion del formato del dui
            $validator = Validator::make($request->all(), [
                'SelectedPatientDui' => 'required|regex:/^[0-9]{8}-[0-9]$/',
                'SelectedDoctorDui' => 'required|regex:/^[0-9]{8}-[0-9]$/'
            ]);
            if ($validator->fails()) {
                return response('Error de validacion: ' . $validator->messages()->first(), 400);
            }
            if (MedicalAppointment::where('appointment_date', $request->Date)->where('id_patient', $request->SelectedPatientDui)->where('id_doctor', $request->SelectedDoctorDui)->first() != null) {
                return response('Esta cita ya esta registrada', 400);
            }
            if (MedicalAppointment::where('appointment_date', $request->Date)->where('id_patient', $request->SelectedPatientDui)->first() != null) {
                return response('El paciente ya posee una cita para el mismo dia', 400);
            }

            $citas = MedicalAppointment::all();
            $newDate = date("Y-m-d", strtotime($request->Date));

            foreach ($citas as $cita) {
                if ($cita->appointment_date == $newDate && $cita->id_doctor == $request->SelectedDoctorDui) {
                    if (strtotime($request->InitialHour) >= strtotime($cita->initial_date) && strtotime($request->InitialHour) < strtotime($cita->finalization_date)) {
                        return response('Ya existe una cita programada para esas horas', 400);
                    }
                    if (strtotime($request->FinalHour) > strtotime($cita->initial_date) && strtotime($request->FinalHour) <= strtotime($cita->finalization_date)) {
                        return response('Ya existe una cita programada para esas horas', 400);
                    }
                }
            }

            // funcion para generar el codigo de la cita
            $codigo = "";
            $abecedario = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            for ($i = 0; $i < 8; $i++) {
                $aleatorio1 = mt_rand(0, 1);
                if ($aleatorio1 == 0) {
                    $aleatorio2 = mt_rand(0, 26);
                    $codigo .= $abecedario[$aleatorio2];
                } else {
                    $aleatorio2 = mt_rand(0, 9);
                    $codigo .= $aleatorio2;
                }
            }
            $date = "";
            $date2 = $request->Date;
            for ($i = 0; $i < strlen($date2); $i++) {
                if (!(strcmp($date2[$i], 'T') == 0)) {
                    $date = $date . $date2[$i];
                } else {
                    $i = strlen($date2);
                }
            }
            $appointment = new MedicalAppointment;
            $appointment->code_medical_appointment = $codigo;
            $appointment->id_patient = $request->SelectedPatientDui;
            $appointment->id_doctor = $request->SelectedDoctorDui;
            $appointment->status = 1;
            $appointment->appointment_date = date("Y-m-d", strtotime($request->Date));
            $appointment->initial_date = $request->InitialHour;
            $appointment->finalization_date = $request->FinalHour;
            $appointment->save();

            $doctor = User::find($request->SelectedDoctorDui);

            $noti = new Notifications;
            $noti->id_user = $request->SelectedPatientDui;
            $noti->message = "Tiene cita el " . $newDate . " con el doctor " . $doctor->name;
            $noti->type = "cita-" . $codigo;
            $noti->status = 1;
            $noti->save();

            return response('cita agregada con exito', 200);
        } catch (QueryException $ex) {
            return response('Ocurrio algun error: ' . $ex->getMessage(), 400);
        }
    }
    public function citasPaciente(Request $request)
    {
        $citasPaciente = MedicalAppointment::with('doctor')->where('id_patient', Auth::user()->dui)
            ->where('status', 1)->get();
        return $citasPaciente;
    }
}
