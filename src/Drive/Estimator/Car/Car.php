<?php

namespace Estimator\Example\Drive\Estimator\Car;

use Estimator\Estimator\MainEvaluationObject;


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
     * Car parts or services classmap
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
