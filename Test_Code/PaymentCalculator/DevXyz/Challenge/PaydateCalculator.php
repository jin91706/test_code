<?php
namespace DevXyz\Challenge;

class PaydateCalculator implements PaydateCalculatorInterface {

    public $paydateModel;
    public $holidays;

    function __construct(string $paydateModel = '', array $holidays = []) {
        $this->paydateModel = $paydateModel;
        $this->holidays = $holidays;
    }

    public function calculatePaydates(string $initialPaydate, int $numberOfPaydates): array{
        
        switch ($this->paydateModel) {
            case PaydateCalculatorInterface::PAYDATE_MODEL_WEEKLY:
                $dateString = '+1 week';
                $pay = $this->dateArray($initialPaydate, $numberOfPaydates, $dateString);
                break;

            case PaydateCalculatorInterface::PAYDATE_MODEL_BIWEEKLY:
                $dateString = '+2 week';
                $pay = $this->dateArray($initialPaydate, $numberOfPaydates, $dateString);
                break;

            case PaydateCalculatorInterface::PAYDATE_MODEL_MONTHLY:
                $dateString = '+1 month';
                $pay = $this->dateArray($initialPaydate, $numberOfPaydates, $dateString);
                break;
            default:
                echo 'Enter a model on the list!';
                break;
        }
        
        return $pay;
    }

    public function dateArray(string $initialPaydate, int $numberOfPaydates, string $dateString): array{
        
        $dates = [];
        $tw = $initialPaydate;
        for ($i=0; $i < $numberOfPaydates; $i++) { 
            
            $tw = date('Y-m-d', strtotime($dateString, strtotime($tw)));
            $hw = '';
            if (Holidays::isWeekend($tw)) {
                // The function nextBusinessDay() will automatically skip a day if the next business day is a Holiday
                $hw = Holidays::nextBusinessDay($tw);
            }
    
            if (Holidays::isHoliday($tw)) {
                // The function previousBusinessDay() will automatically skip a day if the previous business day is a weekend
                $hw = Holidays::previousBusinessDay($tw);
            }

            $dates[] = !empty($hw) ? $hw : $tw;
        }

        return $dates;
    }

}

?>