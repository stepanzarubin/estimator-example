<?php

namespace Estimator\Example\Drive\Estimator;

use Estimator\Estimator\MainCalculatorObject;

/**
 * Class DriveCalculator
 *
 * Custom logic
 */
class DriveCalculator extends MainCalculatorObject
{
    protected $map = [
        'gas' => 'Estimator\Example\Drive\Estimator\Service\Gas\GasCalculator',
        'spend' => 'Estimator\Example\Drive\Estimator\Service\Spend\SpendCalculator',
        'driver' => 'Estimator\Example\Drive\Estimator\Service\Driver\DriverCalculator',
    ];

    //todo can this be useful?
    /**
     * @var GasCalculator
     */
    //public $gas;
}
