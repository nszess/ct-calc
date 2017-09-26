<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\Services\CalcService;

use App\GiardiaInactivation;
use App\VirusFreeChlorine;
use App\VirusChlorineDioxide;
use App\VirusChloramine;
use App\VirusOzone;
use App\GiardiaChlorineDioxide;
use App\GiardiaChloramine;
use App\GiardiaOzone;

class CalcController extends Controller
{
  protected $data = array();

  //general interpolation formula, used by virus and giardia
  private function interpolate($x, $x0, $y0, $x1, $y1)
  {
    if ($x0 == $x1 and $y0 == $y1) {
      return $y1;
    }
    return (($x-$x0) * ($y1-$y0) / ($x1-$x0)) + $y0;
  }

  //general rounding formulas, used by giardia and virus
  private function roundUp($n, $x)
  {
    return $x * (ceil(abs($n/$x)));
  }
  private function roundDown($n, $x)
  {
    $result = $x * (floor(abs($n/$x)));
    if ($result == 0) {
      return 1;
    } else {
      return $result;
    }
  }

  private function giardiaInterpolate($disinfectantType, $temp, $logGiardia)
  {
    $tempHigh = intval($this->roundUp($temp, 5));
    $tempLow = intval($this->roundDown($temp, 5));

    //return $tempHigh;//KILL

    switch ($disinfectantType) {
      case 1://Free Chlorine
        //round temp to 5 between 1-25
        $temp_roundUp = ceil($_dis * 5) / 5;
        $temp_roundDown = floor($_dis * 5) / 5;

        //round logGiardia to 0.5 between 0.5-3
        $logGiardia_roundUp = ceil($_dis * 5) / 5;
        $logGiardia_roundDown = floor($_dis * 5) / 5;
        break;

      case 2://Chlorine Dioxide
        $resultHigh = GiardiaChlorineDioxide::where('temperature', $tempHigh)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;

        $resultLow = GiardiaChlorineDioxide::where('temperature', $tempLow)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;
        break;

      case 3://Chloramine
        $resultHigh = GiardiaChloramine::where('temperature', $tempHigh)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;

        $resultLow = GiardiaChloramine::where('temperature', $tempLow)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;
        break;

      case 4://Ozone
        $resultHigh = GiardiaOzone::where('temperature', $tempHigh)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;

        $resultLow = GiardiaOzone::where('temperature', $tempLow)
          ->where('log_giardia', 2*$logGiardia)
          ->first()
          ->inactivation;
        break;

      default: return -1;
    }
    return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
  }

  private function virusInterpolate($disinfectantType, $temp, $logVirus)
  {
    //ONLY INTERPOLATE ON TEMP
    //never interpolate log in all tables

    $tempHigh = intval($this->roundUp($temp, 5));
    $tempLow = intval($this->roundDown($temp, 5));

    //return $tempHigh;

    switch ($disinfectantType) {
      case 1://Free Chlorine
        $resultHigh = VirusFreeChlorine::where('temperature', $tempHigh)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;

        $resultLow = VirusFreeChlorine::where('temperature', $tempLow)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;
        break;

      case 2://Chlorine Dioxide
        $resultHigh = VirusChlorineDioxide::where('temperature', $tempHigh)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;

        $resultLow = VirusChlorineDioxide::where('temperature', $tempLow)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;
        break;

      case 3://Chloramine
        $resultHigh = VirusChloramine::where('temperature', $tempHigh)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;

        $resultLow = VirusChloramine::where('temperature', $tempLow)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;
        break;

      case 4://Ozone
        $resultHigh = VirusOzone::where('temperature', $tempHigh)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;

        $resultLow = VirusOzone::where('temperature', $tempLow)
          ->where('log_virus', $logVirus)
          ->first()
          ->inactivation;
      break;

      default: return -1;
    }
    return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
  }

  private function giardiaRound($disinfectantConcentration, $temp, $ph, $logGiardia)
  {
    //round numbers down
    $_temp = floor($temp * 2) / 2;//lowest .5 !!WRONG!! 0.5, 5, 10, 15, 20, 25
    $_ph = floor($ph * 2) / 2;//lowest .5
    $_logGiardia = floor($logGiardia * 2) / 2;//lowest .5
    $_disinfectantConcentration = floor($disinfectantConcentration * 5) / 5;//lowest .2

    //return query result
    return GiardiaInactivation::where('temperature', $_temp)
      ->where('ph', $_ph)
      ->where('log_giardia', $_logGiardia)
      ->where('disinfectant', $_disinfectantConcentration)
      ->first()
      ->inactivation;
  }

  private function giardiaFormula($disinfectantConcentration, $time, $temp, $ph, $logGiardia)
  {
    if ($temp < 12.5) {
      return (0.353 * $logGiardia) * (12.006 + exp(2.46 - (0.073 * $temp) + (0.125 * $disinfectantConcentration) + (0.389 * $ph)));
    } else {
      return (0.361 * $logGiardia) * (-2.261 + exp(2.69 - (0.065 * $temp) + (0.111 * $disinfectantConcentration) + (0.361 * $ph)));
    }
  }





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
          $ctRequiredGiardia = $this->giardiaFormula($disinfectantConcentration, $time, $temp, $ph, $logGiardia);
          break;

        default: break;//handle interpolation in else
      }
    } else {//disinfectant != Free Chlorine
      $ctRequiredGiardia = $this->giardiaInterpolate($disinfectantType, $temp, $logGiardia);
    }

    $ctRequiredVirus = $this->virusInterpolate($disinfectantType, $temp, $logVirus);
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
