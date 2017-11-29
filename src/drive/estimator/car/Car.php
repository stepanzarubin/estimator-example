<?php

namespace Estimator\Example\Drive\Estimator\Car;

use Estimator\Estimator\MainEvaluationObject;

/**
 * Car common
 */
//require_once 'CarCommon.php';
//require_once 'CarTires.php';
/* end */

/**
 * Car parts or services
 */
//require_once __DIR__ . '/../services/gas/Gas.php';
//require_once __DIR__ . '/../services/spend/Spend.php';
//require_once __DIR__ . '/../services/driver/Driver.php';
/* end */

/**
 * Class Car
 * This is not a car itself, it is just car information required for evaluation
 *
 * @property CarCommon $common
 */
class Car extends MainEvaluationObject
{
    //todo tests to cover possible scenarios
    //Exception: 'doors' has to be an object
    //public $doors;

    //todo electricity calculator for electric car

    /**
     * @var array
     */
    protected $map = [
        'gas' => 'Estimator\Example\Drive\Estimator\Service\Gas\Gas',
        'spend' => 'Estimator\Example\Drive\Estimator\Service\Spend\Spend',
        'driver' => 'Estimator\Example\Drive\Estimator\Service\Driver\Driver',
    ];

    /**
     * @var Gas
     */
    public $gas;

    /**
     * @var Spend
     */
    public $spend;

    /**
     * @var Driver
     */
    public $driver;
}
