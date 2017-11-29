<?php

namespace Estimator\Example\Drive\Estimator;

use Estimator\Example\Drive\Model\CRMCar;

/**
 * todo add Estimator lib class
 * Prepares data in necessary format for the calculation
 * Class CRMDataPreparer
 */
class CRMDataPreparer
{
    /**
     * When generating internal CRM estimate is the only goal
     *
     * @param CRMCar $crmCar
     * @return Car
     */
    public function getCar(CRMCar $crmCar)
    {

    }

    /**
     * CRM and estimator are separate
     * But their models has to be mirror which is a duplicate
     *
     * Should contain just enough data to accomplish calculation
     *
     * @param CRMCar $crmCar
     * @return array
     */
    public function getCarArray(CRMCar $crmCar)
    {
        //of course more clear would be to create mirror class, fill it and translate into JSON

        $common = [];
        $id = $crmCar->getId(); //objects without id cannot save estimate
        if ($id)
            $common['id'] = $id;

        $common['is_electric'] = $crmCar->is_electric;
        $common['tires'] = [
            'qnt' => $crmCar->tiresQnt,
            'oneTireSpendIncreasePercent' => $crmCar->oneTireSpendIncreasePercent
        ];
        $common['distance'] = $crmCar->distance;

        $array = [
            'common' => $common,
            'spend' => [
                'firstAndLastMileSpend' => $crmCar->firstAndLastMileSpend,
                'restMileSpend' => $crmCar->restMileSpend
            ]
        ];

        if ($crmCar->firstAndLastMileGas > 0 || $crmCar->restMileGas > 0)
        {
            $array['gas']['firstAndLastMileGas'] = $crmCar->firstAndLastMileGas;
            $array['gas']['restMileGas'] = $crmCar->restMileGas;
        }

        if ($crmCar->spendDiscountPercent != 0)
            $array['spend']['adjustment']['percent'] = $crmCar->spendDiscountPercent;

        if ($crmCar->spendDiscountAmount != 0)
             $array['spend']['adjustment']['amount'] = $crmCar->spendDiscountAmount;

        if ($crmCar->driverPerMile > 0)
            $array['driver']['perMile'] = $crmCar->driverPerMile;

        return $array;
    }

    /**
     * @param CRMCar $crmCar
     * @return string
     */
    public function getCarJson(CRMCar $crmCar)
    {
        return json_encode($this->getCarArray($crmCar));
    }

    /**
     * Should contain just enough data to accomplish calculation
     *
     * @param CRMCar|null $crmCar passed to check if there is already saved tariff for this particular instance
     * @return string
     */
    public function getTariffArray(CRMCar $crmCar = null)
    {
        //switching car type to electric/gas will make estimate not valid
        return [
            'services' => [
                'gas',
                'spend',
                'driver',
            ],
            'gas' => [
                'gasLiterCost' => 1
            ]
        ];
    }

    /**
     * @param CRMCar|null $crmCar
     * @return string
     */
    public function getTariffJson(CRMCar $crmCar = null)
    {
        return json_encode($this->getTariffArray($crmCar));
    }
}