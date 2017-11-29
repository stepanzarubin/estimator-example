<?php

namespace Estimator\Example\Drive\Estimator\Service\Gas;

use Estimator\Estimator\CalculatorObject;

/**
 * Class GasCalculator
 *
 * @property Gas $evaluationObject
 * @property GasTariff $tariffObject
 */
class GasCalculator extends CalculatorObject
{
    /**
     * todo define calculations which should be a part of any calculator to force calculation order
     * @return float
     */
    public function calculate()
    {
        $total = 0;

        if ($this->common->is_electric) {
            $this->log("Electric car has no gas cost.");
            return $total;
        }

        $firstAndLastMileGas = $this->evaluationObject->firstAndLastMileGas;
        $restMileGas = $this->evaluationObject->restMileGas;
        if ($this->common->distance <= 2)
            $litres = $this->common->distance * $firstAndLastMileGas;
        else
            $litres = 2 * $firstAndLastMileGas + ($this->common->distance - 2) * $restMileGas;

        $litres = round($litres, 2);
            $this->log("Car will spend $litres litres of gas.");
        $total = round($litres * $this->tariffObject->gasLiterCost, 2);
            $this->log("\"$this->name\" cost = $$total");

        $effective = $this->applyAdjustment($total);

        $this->writeCost($total, $effective);
        return $this->getEffectiveCost();
    }
}
