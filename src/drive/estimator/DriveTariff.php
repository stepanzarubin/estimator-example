<?php

namespace Estimator\Example\Drive\Estimator;

use Estimator\Estimator\TariffObject;


class DriveTariff extends TariffObject
{
    /**
     * Specifies order of calculation
     * services has to be listed since not all of them can be present in eval object
     *
     * @var array
     */
    public $services;

    /**
     * Tariffs classmap
     * @var array
     */
    protected $map = [
        'gas' => 'Estimator\Example\Drive\Estimator\Service\Gas\GasTariff',
    ];

    /**
     * @var GasTariff
     */
    public $gas;
}