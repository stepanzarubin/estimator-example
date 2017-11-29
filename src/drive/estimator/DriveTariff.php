<?php

namespace Estimator\Example\Drive\Estimator;

//use Estimator\Example\Drive\Estimator\Service\Gas\GasTariff;
//use Estimator\Example\Drive\Estimator\Service\Spend\Spend;
//use Estimator\Example\Drive\Estimator\Service\Driver;

use Estimator\Estimator\TariffObject;

//tariffs
//require_once 'service/gas/GasTariff.php';

class DriveTariff extends TariffObject
{
    /**
     * Specifies order of calculation
     * services has to be listed since not all of them can be present in eval object
     *
     * @var array
     */
    public $services;

    protected $map = [
        'gas' => 'Estimator\Example\Drive\Estimator\Service\Gas\GasTariff',
    ];

    /**
     * @var GasTariff
     */
    public $gas;
}