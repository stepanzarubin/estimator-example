<?php

namespace Estimator\Example\Drive\Estimator\Service\Spend;

use Estimator\Estimator\ServiceEvaluationObject;

/**
 * Class Spend
 */
class Spend extends ServiceEvaluationObject
{
    /**
     * @var float
     */
    public $firstAndLastMileSpend;
    /**
     * @var float
     */
    public $restMileSpend;
}