<?php
        //Enter your code here, enjoy!


$start = 12;
$end = 11;

$dir = 'clockwise';

if ($dir === 'clockwise') {
    
    if ($start > $end) {
        $start1 = 25 - $start;
        $dis = $start1 + $end;
    } else {
        $dis = $end - $start;
    }
    
} else {
    
    if ( $start > $end ) {
        $dis = $start - $end;
    } else {
        $end1 = 25 - $end;
        $dis = $start + $end1;
    }
    
}

echo $dis;



        //Enter your code here, enjoy!
        $a = [3, 6, 4, 4, 5, 5, 8, 8, 1, 1, 1, 9];

        $count = array_count_values($a);
        
        ksort($count);
        
        asort($count);
        print_r($count);
        
        $sorted = [];
        foreach ($count as $key => $val) {
            
            foreach ($a as $val) {
                if ($val == $key) {
                    
                    $sorted[] = $val;
                }
            }
        }
        //print_r($sorted);