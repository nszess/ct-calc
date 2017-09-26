<?php

namespace App\Http\Controllers\Services;

use App\ChloramineGiardiaInactivation;
use App\ChloramineVirusInactivation;
use App\ChlorineDioxideGiardiaInactivation;
use App\ChlorineDioxideVirusInactivation;
use App\FreeChlorineGiardiaInactivation;
use App\FreeChlorineVirusInactivation;
use App\OzoneGiardiaInactivation;
use App\OzoneVirusInactivation;

class CalcService
{

    //general interpolation formula, used by virus and giardia
    public function interpolate($x, $x0, $y0, $x1, $y1)
    {
      if ($x0 == $x1 and $y0 == $y1) {
        return $y1;
      }
      return (($x-$x0) * ($y1-$y0) / ($x1-$x0)) + $y0;
    }

    //general rounding formulas, used by giardia and virus
    public function roundUp($n, $x)
    {
      return $x * (ceil(abs($n/$x)));
    }
    public function roundDown($n, $x)
    {
      $result = $x * (floor(abs($n/$x)));
      if ($result == 0) {
        return 1;
      } else {
        return $result;
      }
    }

    public function giardiaInterpolate($disinfectantType, $temp, $logGiardia)
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
          $resultHigh = ChlorineDioxideGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;

          $resultLow = ChlorineDioxideGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;
          break;

        case 3://Chloramine
          $resultHigh = ChloramineGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;

          $resultLow = ChloramineGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;
          break;

        case 4://Ozone
          $resultHigh = OzoneGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;

          $resultLow = OzoneGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', 2*$logGiardia)
            ->first()
            ->inactivation;
          break;

        default: return -1;
      }
      return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
    }

    public function virusInterpolate($disinfectantType, $temp, $logVirus)
    {
      //ONLY INTERPOLATE ON TEMP
      //never interpolate log in all tables

      $tempHigh = intval($this->roundUp($temp, 5));
      $tempLow = intval($this->roundDown($temp, 5));

      //return $tempHigh;

      switch ($disinfectantType) {
        case 1://Free Chlorine
          $resultHigh = FreeChlorineVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = FreeChlorineVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 2://Chlorine Dioxide
          $resultHigh = ChlorineDioxideVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = ChlorineDioxideVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 3://Chloramine
          $resultHigh = ChloramineVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = ChloramineVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 4://Ozone
          $resultHigh = OzoneVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = OzoneVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
        break;

        default: return -1;
      }
      return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
    }

    public function giardiaRound($disinfectantConcentration, $temp, $ph, $logGiardia)
    {
      //round numbers down
      $_temp = floor($temp * 2) / 2;//lowest .5 !!WRONG!! 0.5, 5, 10, 15, 20, 25
      $_ph = floor($ph * 2) / 2;//lowest .5
      $_logGiardia = floor($logGiardia * 2) / 2;//lowest .5
      $_disinfectantConcentration = floor($disinfectantConcentration * 5) / 5;//lowest .2

      //return query result
      return FreeChlorineGiardiaInactivation::where('temperature', $_temp)
        ->where('ph', $_ph)
        ->where('log_inactivation', $_logGiardia)
        ->where('disinfectant', $_disinfectantConcentration)
        ->first()
        ->inactivation;
    }

    public function giardiaFormula($disinfectantConcentration, $time, $temp, $ph, $logGiardia)
    {
      if ($temp < 12.5) {
        return (0.353 * $logGiardia) * (12.006 + exp(2.46 - (0.073 * $temp) + (0.125 * $disinfectantConcentration) + (0.389 * $ph)));
      } else {
        return (0.361 * $logGiardia) * (-2.261 + exp(2.69 - (0.065 * $temp) + (0.111 * $disinfectantConcentration) + (0.361 * $ph)));
      }
    }
}
