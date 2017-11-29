<?php

namespace Estimator\Example\Drive\Estimator\Service\Spend;

use Estimator\Estimator\CalculatorObject;

/**
 * Class SpendCalculator
 *
 * @property Spend $evaluationObject
 */
class SpendCalculator extends CalculatorObject
{
    /**
     * @return float
     */
    public function calculate()
    {
        $total = 0;

        $firstAndLastMileSpend = $this->evaluationObject->firstAndLastMileSpend;
        $restMileSpend = $this->evaluationObject->restMileSpend;
        if ($this->common->distance <= 2)
            $total = $this->common->distance * $firstAndLastMileSpend;
        else
            $total = 2 * $firstAndLastMileSpend + ($this->common->distance - 2) * $restMileSpend;

        $total = round($total, 2);
        //todo should such log message be there?
        //why not? it does not tell anything about calculation process, but probably should
        $this->log("\"$this->name\" cost = $$total");

        $effective = $this->applyAdjustment($total);

        $this->writeCost($total, $effective);
        return $this->getEffectiveCost();
    }
}
