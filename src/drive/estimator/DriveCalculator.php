<?php

namespace Estimator\Example\Drive\Estimator;

use Estimator\Estimator\MainCalculatorObject;

//main evaluation object
//require_once 'car/Car.php';

//main tariff
//require_once 'DriveTariff.php';

//drive calculators
//require_once 'services/gas/GasCalculator.php';
//require_once 'services/spend/SpendCalculator.php';
//require_once 'services/driver/DriverCalculator.php';

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
