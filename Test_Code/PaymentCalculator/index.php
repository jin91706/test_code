<?php
/* run # composer install
 *
 * To run program, enter the following command: # php index.php [Initial Paydate] [Paydate Model] [Number of Payments]
 * example: # php index.php 2022-4-5 BIWEEKLY 5
 */

include('vendor/autoload.php');

if (empty($argv['1']) || empty($argv['2']) || empty($argv['3'])) {
    echo "Enter these arguments in this order: Initial Payment Date(example: 2022-4-15) PayDate Model(example: MONTHLY, BIWEEKLY, WEEKLY) Number of Payments(number greater then 0)\n";
    exit();
}

$model = ['MONTHLY','BIWEEKLY','WEEKLY'];
if (!in_array($argv['2'], $model)) {
    echo "PayDate Model must be one of the following: MONTHLY, BIWEEKLY, WEEKLY" . "\n";
    exit();
}
if ($argv['3'] < 1) {
    echo "Number of Payments must be greater then zero" . "\n";
    exit();
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

if (!validateDate($argv['1'])) {
    echo "Initial Payment Date needs to be in the following format: Y-m-d (example: 2022-04-05)\n";
    exit();
}

$now = date('Y-m-d');
$id = date('Y-m-d', strtotime($argv['1']));

if ($now == $id) {
    echo "Initial Paydate can not be today!\n";
    exit();
}

$initialPaydate = $argv['1'];
$paydateModel = $argv['2'];
$count = $argv['3'];
$holidays = [];
$pc = new DevXyz\Challenge\PaydateCalculator($paydateModel, $holidays);
$pay = $pc->calculatePaydates($initialPaydate, $count);
foreach ($pay as $key => $value) {
    echo $value . "\n";
}

?>