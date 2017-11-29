<?php

namespace Estimator\Example\Drive\Estimator\Service\Gas;

use Estimator\Estimator\ServiceEvaluationObject;

/**
 * Class Gas
 */
class Gas extends ServiceEvaluationObject
{
    /**
     * A AM NOT SURE IF THIS IS STILL VALID, JUST CHECK ON PRACTICE
     * todo should be possible to have such per simple objects
     * it is similar to common but do not have all common features
     *
     * what is the difference? answering this question will also answer the question why
     * should I distinguish such objects from Main object and from sub objects (for simplicity?)
     * @var
     */
    public $gasSubObject;

    /**
     * @var float
     */
    public $firstAndLastMileGas;
    /**
     * @var float
     */
    public $restMileGas;
}