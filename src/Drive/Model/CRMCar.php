<?php

namespace Estimator\Example\Drive\Model;

/**
 * CRM model example
 *
 * Data can be organized in any way
 */
class CRMCar
{
    /**
     * Only cars with id can save estimate
     * @var
     */
    protected $_id;

    public function __construct($id = null)
    {
        $this->_id = $id;
    }

    /**
     * Defaults
     */

    public $is_electric = false;

    public $tiresQnt = 4;
    public $oneTireSpendIncreasePercent = 0.4;

    public $firstAndLastMileGas = 0.4;
    public $restMileGas = 0.2;

    public $firstAndLastMileSpend = 2;
    public $restMileSpend = 1;
    public $spendDiscountPercent = 0;
    public $spendDiscountAmount = 0;

    public $distance = 10;

    public $driverPerMile = 0.5;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }
}
