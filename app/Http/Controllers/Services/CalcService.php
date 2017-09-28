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

class CalcService {

    //general interpolation formula, used by virus and giardia
    private function interpolate($x, $x0, $y0, $x1, $y1)
    {
      if ($x0 == $x1 and $y0 == $y1) {
        return $y1;
      }
      return (($x-$x0) * ($y1-$y0) / ($x1-$x0)) + $y0;
    }

    //general rounds, used by giardia and virus
    private function roundUp($n, $x)
    {
      return $x * (ceil(abs($n/$x)));
    }

    public function roundDown($n, $x)
    {
      return $x * (floor(abs($n/$x)));
    }

    //specialised round down, used !freeChlorine
    private function roundDownTemp($n, $x) {
      $result = $this->roundDown($n, $x);
      if ($result < 1) {
        return 1;
      } else {
        return $result;
      }
    }

    //specialised round down, used by free chlorine round
    private function roundDownTempFreeChlorine($n, $x) {
      $result = $this->roundDown($n, $x);
      if ($result < 0.5) {
        return 0.5;
      } else {
        return $result;
      }
    }

    private function roundDownPh($n, $x) {
      $result = $this->roundDown($n, $x);
      if ($result < 6) {
        return 6;
      } else {
        return $result;
      }
    }

    private function roundDownDisinfectantConectration($n, $x) {
      $result = $this->roundDown($n, $x);
      if ($result < 0.4) {
        return 0.4;
      } else {
        return round($result, 1);//round result to 1 decimal place, so float can be used to query db
      }
    }


    public function giardiaInterpolate($disinfectantType, $temp, $logGiardia)
    {
      $tempHigh = intval($this->roundUp($temp, 5));
      $tempLow = intval($this->roundDownTemp($temp, 5));

      switch ($disinfectantType) {
        case 'chlorine_dioxide':
          $resultHigh = ChlorineDioxideGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;

          $resultLow = ChlorineDioxideGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;
          break;

        case 'chloramine':
          $resultHigh = ChloramineGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;

          $resultLow = ChloramineGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;
          break;

        case 'ozone':
          $resultHigh = OzoneGiardiaInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;

          $resultLow = OzoneGiardiaInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logGiardia)
            ->first()
            ->inactivation;
          break;

        //TODO ERROR HANDELING
        default: return -1;
      }

      return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
    }

    public function virusInterpolate($disinfectantType, $temp, $logVirus)
    {
      $tempHigh = intval($this->roundUp($temp, 5));
      $tempLow = intval($this->roundDownTemp($temp, 5));

      switch ($disinfectantType) {
        case 'free_chlorine':
          $resultHigh = FreeChlorineVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = FreeChlorineVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 'chlorine_dioxide':
          $resultHigh = ChlorineDioxideVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = ChlorineDioxideVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 'chloramine':
          $resultHigh = ChloramineVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = ChloramineVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
          break;

        case 'ozone':
          $resultHigh = OzoneVirusInactivation::where('temperature', $tempHigh)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;

          $resultLow = OzoneVirusInactivation::where('temperature', $tempLow)
            ->where('log_inactivation', $logVirus)
            ->first()
            ->inactivation;
        break;

        //TODO ERROR HANDELING
        default: return -1;
      }
      return $this->interpolate($temp, $tempLow, $resultLow, $tempHigh, $resultHigh);
    }

    public function giardiaRound($disinfectantConcentration, $temp, $ph, $logGiardia)
    {
      return FreeChlorineGiardiaInactivation::where('temperature', $this->roundDownTemp($temp, 5))
        ->where('ph', $this->roundDownPh($ph, 0.5))
        ->where('log_inactivation', $logGiardia)
        ->where('disinfectant_concentration', $this->roundDownDisinfectantConectration($disinfectantConcentration, 0.2) )
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
