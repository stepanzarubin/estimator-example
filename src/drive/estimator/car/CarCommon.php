<?php

namespace Estimator\Example\Drive\Estimator\Car;

use Estimator\Estimator\EvaluationObject;

/**
 * Class CarCommon
 */
class CarCommon extends EvaluationObject
{
    /**
     * @var array
     */
    protected $map = [
        'tires'=>'Estimator\Example\Drive\Estimator\Car\CarTires'
    ];

    /**
     * Only cars with id can save estimate
     * @var
     */
    public $id;

    /**
     * @var bool
     */
    public $is_electric = false;

    /**
     * @var float
     */
    public $distance = 0.00;

    /**
     * todo when CarCommon is created:
     * 1. default CarTires has to be created as well
     * OR
     * 2. if not defined, has to be ignored by calculator
     *
     * Default values has to give same effect as not having description at all
     * So probably both cases are ok
     * Easier to just ignore
     *
     * @var CarTires
     */
    public $tires;
}