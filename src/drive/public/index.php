<?php

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

use Estimator\Example\Drive\Model\CRMCar;
use Estimator\Example\Drive\Estimator\CRMDataPreparer;

use Estimator\Example\Drive\Estimator\DriveTariff;
use Estimator\Example\Drive\Estimator\DriveCalculator;

use Estimator\Example\Drive\Estimator\Car\Car;
use Estimator\Estimator\Estimate;

/* Debug functions */
function prePrintR($value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit;
}

function preEcho($value) {
    echo '<pre>';
    echo $value;
    echo '</pre>';
    exit;
}
/* end Debug functions */

/* DB */
$db_file = dirname(__DIR__) . '/estimator/data/db.sqlite3';
$db = new SQLite3($db_file);

if (isset($_POST['cleanEstimates']))
{
    $db->exec("DELETE FROM estimate");
    header("index.php");
}

$db->exec("CREATE TABLE IF NOT EXISTS estimate (id INTEGER PRIMARY KEY AUTOINCREMENT, evaluation_object_id INTEGER NOT NULL, estimate TEXT)");
/* end DB */

$car_1 = new CRMCar(); //no id
$car_1->spendDiscountPercent = 5;

$car_2 = new CRMCar(2);
$car_2->is_electric = true;
$car_2->driverPerMile = 0; //robot is driving
$car_2->oneTireSpendIncreasePercent = 0.6;
$car_2->firstAndLastMileSpend = 4;
$car_2->restMileSpend = 2;
$car_2->spendDiscountAmount = -1;

//no gas
$car_2->firstAndLastMileGas = 0;
$car_2->restMileGas = 0;

$CRMDataPreparer = new CRMDataPreparer();

$crmCars = [];
$crmCars[] = $CRMDataPreparer->getCarArray($car_1);
$crmCars[] = $CRMDataPreparer->getCarArray($car_2);

$crmCarTariff = $CRMDataPreparer->getTariffArray();
//end

/**
 * Defaults
 */


//from crm
$evaluationObjectsJson = json_encode($crmCars,JSON_PRETTY_PRINT);

//from crm
$tariffJson = json_encode($crmCarTariff,JSON_PRETTY_PRINT);

/* end defaults */

if (!empty($_POST))
{
    //overwrite defaults
    $evaluationObjectsJson = $_POST['evaluationObjects'];
    $tariffJson            = $_POST['tariff'];
}


/**
 * Get input data
 */
//evaluation objects
$carsConfigArray = json_decode($evaluationObjectsJson);
//prePrintR($carsConfigArray);

// todo do I need tires tariff? probably no, it has to be part of a spend calculation
// but what will happen if I need to pass one tariff to another tariff? e.g. tires tariff to gas tariff
// IS THIS RESOLVED?
// [common] => EvaluationObject Object
// (
//     [is_electric] => true
//     [tires] => stdClass Object
//         (
//             [qnt] => 4
//             [oneTireSpendIncreasePercent] => 0.6
//         )
// )

//tariff
$tariffConfig = json_decode($tariffJson);
//prePrintR($tariffConfig);
$tariff = new DriveTariff($tariffConfig);
//prePrintR($tariff);

/* end input data */

$result = [];

/**
 * Evaluate and write results
 */
foreach ($carsConfigArray as $carConfig)
{
    $car = new Car($carConfig);

    //prePrintR($carConfig);
    //prePrintR($car);

    $driveCalculator = new DriveCalculator($car, $tariff);
    $driveCalculator->calculate();
    $driveCalculatorResult = $driveCalculator->getResult();
    $result[] = $driveCalculatorResult;

    //objects without id cannot save estimate
    if ($car->common->id && isset($_POST['saveEstimate']))
    {
        /**
         * 1. Evaluation Object
         * 2. Tariff
         * 3. Calculation log
         */

        //todo result has to be clean JSON, similar to EO and tariff
        $estimate = new Estimate($carConfig, $tariffConfig, $driveCalculatorResult->asArray());
        $estimateJson = $estimate->asJson();

        //preEcho($estimateJson);

        $db->exec("
          INSERT INTO estimate (evaluation_object_id, estimate)
          VALUES
                ('{$car->common->id}', '{$estimateJson}')
        ");
    }
}
/* end evaluation */

//get estimates from db
$dbEstimates = [];
$dbEstimatesResult = $db->query('SELECT estimate FROM estimate');
while ($row = $dbEstimatesResult->fetchArray(SQLITE3_ASSOC)) {
    $dbEstimates[] = json_decode($row['estimate']);
}

$dbEstimates = json_encode($dbEstimates,JSON_PRETTY_PRINT);
//end

//prePrintR($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drive</title>
    <link rel="stylesheet" type="text/css" href="assets/lds/styles/salesforce-lightning-design-system.min.css">
    <link rel="stylesheet" type="text/css" href="assets/index.css">
</head>
<body>

<div class="slds-context-bar">
    <div class="slds-context-bar__primary slds-context-bar__item--divider-right">
        <div class="slds-context-bar__item slds-context-bar__dropdown-trigger slds-dropdown-trigger slds-dropdown-trigger--click slds-no-hover">
            <div class="slds-context-bar__icon-action">
                <a href="javascript:void(0);" class="slds-icon-waffle_container slds-context-bar__button">
                    <div class="slds-icon-waffle">
                        <div class="slds-r1"></div>
                        <div class="slds-r2"></div>
                        <div class="slds-r3"></div>
                        <div class="slds-r4"></div>
                        <div class="slds-r5"></div>
                        <div class="slds-r6"></div>
                        <div class="slds-r7"></div>
                        <div class="slds-r8"></div>
                        <div class="slds-r9"></div>
                    </div>
                    <span class="slds-assistive-text">Open App Launcher</span>
                </a>
            </div>
            <span class="slds-context-bar__label-action slds-context-bar__app-name">
        <span class="slds-truncate" title="{ props.appName || &#x27;App Name&#x27; }">Driving Calculator</span>
      </span>
        </div>
    </div>
    <nav class="slds-context-bar__secondary" role="navigation">
        <ul class="slds-grid">
            <li class="slds-context-bar__item">
                <a href="javascript:void(0);" class="slds-context-bar__label-action" title="Home">
                    <span class="slds-truncate">Home</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="slds-grid slds-wrap slds-m-top--xxx-small">

    <div class="slds-p-horizontal--small slds-size--1-of-2">

            <div class="slds-box--small slds-theme--shade">


                <form method="post">
                    <div class="slds-form-element">
<!--                        <label class="slds-form-element__label" for="evaluationObjects">Evaluation Objects</label>-->
                        <div class="slds-text-heading--medium">Evaluation Objects</div>
                        <div class="slds-form-element__control">
                            <textarea id="evaluationObjects" name="evaluationObjects" class="slds-textarea" placeholder="Placeholder Text"><?php echo $evaluationObjectsJson ?></textarea>
                        </div>
                    </div>

                    <div class="slds-form-element">
<!--                        <label class="slds-form-element__label" for="tariff">Tariff</label>-->
                        <div class="slds-text-heading--medium">Tariff</div>
                        <div class="slds-form-element__control">
                            <textarea id="tariff" name="tariff" class="slds-textarea" placeholder="Placeholder Text"><?php echo $tariffJson ?></textarea>
                        </div>
                    </div>

                    <div class="slds-form-element slds-m-top--xxx-small">
                        <input class="slds-button slds-button--brand" type="submit" name="evaluate" value="Evaluate">
                        <input class="slds-button slds-button--brand" type="submit" name="saveEstimate" value="Save Estimate">
                        <input class="slds-button slds-button--destructive" type="submit" name="cleanEstimates" value="Clean Estimates">
                    </div>
                </form>

            </div>

    </div>

    <div class="slds-p-horizontal--small slds-size--1-of-2">

        <div class="slds-grid slds-grid--vertical slds-grid--vertical-stretch slds-grid--pull-padded">

                <div class="slds-box--small slds-theme--shade">

                    <div class="slds-text-heading--medium">Result (representation)</div>

                    <table class="slds-table slds-table--bordered slds-table--cell-buffer">
                        <thead>
                            <tr class="slds-text-title--caps">
                                <th scope="col" style="width: 5%;">
                                    <div class="slds-truncate" title="Evaluation Order">Evaluation Order</div>
                                </th>
                                <th scope="col" style="width: 20%;">
                                    <div class="slds-truncate" title="Service">Service</div>
                                </th>
                                <th scope="col">
                                    <div class="slds-truncate" title="Calculation Log">Calculation Log</div>
                                </th>
                                <th scope="col" style="width: 10%;">
                                    <div class="slds-truncate" title="Total">Total</div>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            /**
                             * @var $evalObjectRow Estimator\Estimator\CalculatorResult
                             */
                            ?>
                            <?php foreach($result as $carOrder => $evalObjectRow) : ?>
                                <?php
                                    //prePrintR($evalObjectRow)
                                ?>
                                <tr class="slds-text-title--caps">
                                    <th scope="row" colspan="4">
                                        <?php
                                            $evalObjectTitle = "CAR #" . ++$carOrder;
                                        ?>
                                        <div class="slds-truncate" title="<?php echo $evalObjectTitle ?>"><?php echo $evalObjectTitle ?></div>
                                    </th>
                                </tr>

                                <?php
                                /**
                                 * @var $serviceRow Estimator\Estimator\CalculatorResult
                                 */
                                ?>
                                <?php foreach($evalObjectRow->log as $evalOrder => $serviceRow) : ?>
                                    <?php $evalOrder++ ?>
                                    <?php //prePrintR($serviceRow) ?>
                                    <tr>
                                        <th scope="row">
                                            <div class="slds-truncate" title="<?php echo $evalOrder ?>"><?php echo $evalOrder ?></div>
                                        </th>
                                        <td>
                                            <div class="slds-truncate" title="<?php echo $serviceRow->calculator ?>"><?php echo $serviceRow->calculator ?></div>
                                        </td>
                                        <td>
                                            <!-- when there is only 1 log message show it without list -->
                                            <?php if (!isset($serviceRow->log[1])):?>
                                                <div class="slds-truncate" title="<?php echo "$serviceRow->calculator log" ?>"><?php echo $serviceRow->log[0] ?></div>
                                            <?php else: ?>
                                                <ul title="<?php echo "$serviceRow->calculator log" ?>">
                                                    <?php foreach ($serviceRow->log as $logMessage): ?>
                                                        <li><?php echo $logMessage ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="slds-truncate" title="<?php echo $serviceRow->costEffective ?>"><?php echo $serviceRow->costEffective ?></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>


                <div class="slds-box--small slds-theme--shade">

                    <div class="slds-text-heading--medium">Result (raw)</div>
                    <textarea readonly id="resultRaw" class="slds-textarea"><?php print_r($result) ?></textarea>

                </div>


                <div class="slds-box--small slds-theme--shade">

                    <div class="slds-text-heading--medium">Estimates (raw)</div>
                    <textarea readonly id="estimatesRaw" class="slds-textarea"><?php echo $dbEstimates ?></textarea>

                </div>
        </div>

    </div>


</div>
<!-- end slds-grid -->

</body>
</html>