<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IdentificationFile;
use App\InformationDataFile;
use App\File;
use App\Patient;
use Validator;
use \Illuminate\Database\QueryException;

class expedienteController extends Controller
{
    public function crearPost(Request $request)
    {
        try {
            if (!isset($request->identificacion["gender"], $request->identificacion["age"], $request->identificacion["occupation"], $request->identificacion["father_name"], $request->identificacion["mother_name"], $request->identificacion["attendant_name"], $request->identificacion["attendant_phone"], $request->identificacion["attendant_address"], $request->identificacion["provided_information_name"], $request->identificacion["provided_information_relationship"], $request->identificacion["provided_information_dui"], $request->identificacion["take_information_name"], $request->datos["location"], $request->datos["ethnic"], $request->datos["last_weight"], $request->datos["size"], $request->dui)) {
                return response('Datos incompletos', 400);
            }
            if (Patient::find($request->dui) != null) {
                return response('Esta Paciente ya posee un expediente', 400);
            }

            $identificacion = new IdentificationFile;
            $identificacion->gender = $request->identificacion["gender"];
            $identificacion->age = $request->identificacion["age"];
            $identificacion->marital_status = $request->identificacion["marital_status"];
            $identificacion->occupation = $request->identificacion["occupation"];
            $identificacion->father_name = $request->identificacion["father_name"];
            $identificacion->mother_name = $request->identificacion["mother_name"];
            $identificacion->couple_name = $request->identificacion["couple_name"];
            $identificacion->attendant_name = $request->identificacion["attendant_name"];
            $identificacion->attendant_address = $request->identificacion["attendant_address"];
            $identificacion->attendant_phone = $request->identificacion["attendant_phone"];
            $identificacion->provided_information_name = $request->identificacion["provided_information_name"];
            $identificacion->provided_information_relationship = $request->identificacion["provided_information_relationship"];
            $identificacion->provided_information_dui = $request->identificacion["provided_information_dui"];
            $identificacion->couple_provided_information_name = $request->identificacion["couple_provided_information_name"];
            $identificacion->take_information_name = $request->identificacion["take_information_name"];
            $identificacion->inscription_date = date("Y-m-d");
            $identificacion->save();

            $data = new InformationDataFile;
            $data->highrisk_pregnancy = $request->datos["highrisk_pregnancy"];
            $data->location = $request->datos["location"];
            $data->ethnic = $request->datos["ethnic"];
            $data->literate = $request->datos["literate"];
            $data->studies = $request->datos["studies"];
            $data->lonely = $request->datos["lonely"];
            $data->tbc = $request->datos["tbc"];
            $data->diabetes = $request->datos["diabetes"];
            $data->hipertension = $request->datos["hipertension"];
            $data->preeclamsia = $request->datos["preeclamsia"];
            $data->eclampsia = $request->datos["eclampsia"];
            $data->other_illness = $request->datos["other_illness"];
            $data->surgery = $request->datos["surgery"];
            $data->infertility = $request->datos["infertility"];
            $data->heart_disease = $request->datos["heart_disease"];
            $data->nephropathy = $request->datos["nephropathy"];
            $data->violence = $request->datos["violence"];
            $data->VIH = $request->datos["VIH"];
            $data->end_of_last_pregnancy = explode('T', $request->datos["end_of_last_pregnancy"])[0];
            $data->planned_pregnancy = $request->datos["planned_pregnancy"];
            $data->contraceptives = $request->datos["contraceptives"];
            $data->last_weight = $request->datos["last_weight"];
            $data->size = $request->datos["size"];
            $data->antirubeola = $request->datos["antirubeola"];
            $data->antitetanica = $request->datos["antitetanica"];
            $data->actively_smoke = $request->datos["actively_smoke"];
            $data->passively_smoke = $request->datos["passively_smoke"];
            $data->use_drugs = $request->datos["use_drugs"];
            $data->alcoholic = $request->datos["alcoholic"];
            $data->save();

            $lastIdentificacion = IdentificationFile::all()->last();
            $lastdata = InformationDataFile::all()->last();

            //Generando el codigo aleatorio del expediente
            $codigo = "";
            $parte1 = "";
            $parte2 = "";
            $aleatorio = mt_rand(0, 9999);
            $parte1 .= $aleatorio;
            while (strlen($parte1) != 4) {
                $string = '0';
                $position = '0';
                $parte1 = substr_replace($parte1, $string, $position, 0);
            }
            $aleatorio = mt_rand(0, 99);
            $parte2 .= $aleatorio;
            while (strlen($parte2) != 2) {
                $string = '0';
                $position = '0';
                $parte2 = substr_replace($parte2, $string, $position, 0);
            }
            $codigo = $parte1 . "-" . $parte2;

            $file = new File;
            $file->id_file = $codigo;
            $file->id_identification_file = $lastIdentificacion->id_identification_file;
            $file->id_information_file = $lastdata->id_information_data;
            $file->save();

            $lastFile = File::all()->last();

            $patient = new Patient;
            $patient->id_patient = $request->dui;
            $patient->id_file = $lastFile->id_file;
            $patient->save();


            return response('cita agregada con exito', 200);
        } catch (QueryException $ex) {
            return response('Ocurrio algun error: ' . $ex->getMessage(), 400);
        }
    }
    public function fileByPatient(Request $request)
    {
        $dui = $request->dui;
        $patient = Patient::find($dui);
        if ($patient == null) {
            return response('Esta Paciente ya posee un expediente', 400);
        }
        $file = File::where('id_file', $patient->id_file)->with('informationDatum')->with('identificationFile')->get();
        return $file;
    }
}
