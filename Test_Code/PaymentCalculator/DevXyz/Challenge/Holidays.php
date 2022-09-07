<?php
namespace DevXyz\Challenge;

class Holidays {

    public static function isHoliday(string $paydate): bool{
        
        // Get year from $paydate.
        $currentYear = date('Y', strtotime($paydate));

        $holidays = [
            // New Years Day
            date('Y-m-d', strtotime("first day of january $currentYear")),
            // Martin Luther King, Jr. Day
            date('Y-m-d', strtotime("january $currentYear third monday")),
            // President's Day
            date('Y-m-d', strtotime("february $currentYear third monday")),
            // Easter
            self::getEeasterDatetime($currentYear)->format('Y-m-d'),
            // Memorial Day
            (new \DateTime("Last monday of May $currentYear"))->format("Y-m-d"),
            // Independence Day
            date('Y-m-d', strtotime("july 4 $currentYear")),
            // Labor Day
            date('Y-m-d', strtotime("september $currentYear first monday")),
            // Columbus Day
            date('Y-m-d', strtotime("october $currentYear second monday")),   
            // Veteran's Day
            date('Y-m-d', strtotime("november 11 $currentYear")),
            // Thanksgiving Day
            date('Y-m-d', strtotime("november $currentYear fourth thursday")),
            // Christmas Day
            date('Y-m-d', strtotime("december 25 $currentYear")),
        ];

        return in_array($paydate, $holidays);
    }


    public static function isWeekend(string $paydate): bool{

        $day = date('D', strtotime($paydate));

        if ($day == 'Sun' || $day == 'Sat') {
            return true;
        }
        return false;
    }

    public static function nextBusinessDay(string $paydate): string{

        $newDay = date('Y-m-d', strtotime($paydate . ' +1 Weekday'));
        if (self::isHoliday($newDay)) {
            $newDay = date('Y-m-d', strtotime($newDay . ' +1 day'));
        }
        return $newDay;
    }

    public static function previousBusinessDay(string $paydate): string{

        $newDay = date('Y-m-d', strtotime($paydate . ' -1 Weekday'));
        return $newDay;
    }

    /*
     *
     * This function is from the PHP docs https://www.php.net/manual/en/function.easter-date.php
     * 
     */
    public static function getEeasterDatetime(string $year): object{
        $base = new \DateTime("$year-03-21");
        $days = easter_days($year);
    
        return $base->add(new \DateInterval("P{$days}D"));
    }
}