<?php

namespace Estimator\Example\Drive\Estimator\Car;

use Estimator\Estimator\EvaluationObject;

class CarTires extends EvaluationObject
{
    /**
     * @var int
     */
    public $qnt = 4;

    /**
     * @var float
     */
    public $oneTireSpendIncreasePercent = 0;
}