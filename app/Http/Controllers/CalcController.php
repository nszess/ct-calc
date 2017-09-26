<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\Services\CalcService as CalcService;



class CalcController extends Controller
{
  //protected
  protected $data = array();

  public function calculator_get(Request $request) {
    $disinfectantConcentration = $request->disinfectantConcentration;
    $time = $request->time;
    $temp = $request->temp;
    $ph = $request->ph;
    $disinfectantType = $request->disinfectantType;
    $logGiardia = $request->logGiardia;
    $logVirus = $request->logVirus;
    $calcMethod = $request->calcMethod;

    $data['disinfectantType'] = $disinfectantType;
    $data['disinfectantConcentration'] = $disinfectantConcentration;
    $data['time'] = $time;
    $data['temp'] = $temp;
    $data['ph'] = $ph;
    $data['logGiardia'] = $logGiardia;
    $data['logVirus'] = $logVirus;
    $data['calcMethod'] = $calcMethod;

    return view('pages/calculator', $data);
  }

  public function calculator_post(Request $request)
  {
    $CalcService = new CalcService;

    //validation
    //Only validate on submit
    if( !empty($request->all()) ) {

      //general validation rules
      $validator = Validator::make($request->all(), [
        'disinfectantType' => 'required',
        'time' => 'required',
        'disinfectantConcentration' => 'required',
        'temp' => 'required|numeric|between:0.5,25',
        'logGiardia' => 'required',
        'logVirus' => 'required'
      ]);

      //conditional validation rules based on methodology
      $validator->sometimes('ph', 'required|numeric|between:6,9', function ($input) {
          return $input->disinfectantType == 1;
        })->sometimes('calcMethod', 'required', function ($input) {
          return $input->disinfectantType == 1;
        });

      //preform validation
      $validator->validate();

      //handle validation failure
      if ($validator->fails()) {
        return redirect('calculator')
          ->withErrors($validator)
          ->withInput();
      }
    }

    //init variables
    $disinfectantConcentration = $request->disinfectantConcentration;
    $time = $request->time;
    $temp = $request->temp;
    $ph = $request->ph;
    $disinfectantType = $request->disinfectantType;
    $logGiardia = $request->logGiardia;
    $logVirus = $request->logVirus;
    $calcMethod = $request->calcMethod;

    //calculate ctProvidedGiardia
    $ctProvided = $disinfectantConcentration * $time;

    //TABLES START IN APPENDIX C (C-1), p.135
    if ($disinfectantType == "1") {//PUT IN ENUMS INSTEAD OF "1"
      switch ($calcMethod) {
        case "round"://again, put in ENUM
          $ctRequiredGiardia = $CalcService->giardiaRound($disinfectantConcentration, $temp, $ph, $logGiardia);
          break;

        case "formula":
          $ctRequiredGiardia = $CalcService->giardiaFormula($disinfectantConcentration, $time, $temp, $ph, $logGiardia);
          break;

        default: break;//handle interpolation in else
      }
    } else {//disinfectant != Free Chlorine
      $ctRequiredGiardia = $CalcService->giardiaInterpolate($disinfectantType, $temp, $logGiardia);
    }

    $ctRequiredVirus = $CalcService->virusInterpolate($disinfectantType, $temp, $logVirus);
    //END CALCULATIONS///////////////////////////////////////////////////////////////////////////


    //add to data, pass to view
    //input data
    $data['disinfectantType'] = $disinfectantType;
    $data['disinfectantConcentration'] = $disinfectantConcentration;
    $data['time'] = $time;
    $data['temp'] = $temp;
    $data['ph'] = $ph;
    $data['logGiardia'] = $logGiardia;
    $data['logVirus'] = $logVirus;
    $data['calcMethod'] = $calcMethod;

    //solutions
    $data['ctProvided'] = $ctProvided;
    //giardia solutions
    $data['ctRequiredGiardia'] = $ctRequiredGiardia;
    if ($ctRequiredGiardia != 0) {
      $data['ctComplianceRatioGiardia'] = number_format($ctProvided / $ctRequiredGiardia, 3);//3 decimal places
    } else {
      $data['ctComplianceRatioGiardia'] = 'ERROR: Division by 0. CT Required may not be 0.';
    }
    //virus solutions
    $data['ctRequiredVirus'] = $ctRequiredVirus;
    if ($ctRequiredVirus != 0) {
      $data['ctComplianceRatioVirus'] = number_format($ctProvided / $ctRequiredVirus, 3);//3 decimal places
    } else {
      $data['ctComplianceRatioVirus'] = 'ERROR: Division by 0. CT Required may not be 0.';
    }

    //return view
    return view('pages/results', $data);
  }
}
