<?php

namespace Estimator\Example\Drive\Estimator\Service\Driver;

use Estimator\Estimator\CalculatorObject;

/**
 * Class DriverCalculator
 *
 * @property Driver $evaluationObject
 */
class DriverCalculator extends CalculatorObject
{
    /**
     * @return float
     */
    public function calculate()
    {
        $total = $this->common->distance * $this->evaluationObject->perMile;
        $total = round($total, 2);

        $this->log("Driver cost = $$total.");

        $effective = $this->applyAdjustment($total);

        $this->writeCost($total, $effective);
        return $this->getEffectiveCost();
    }
}
