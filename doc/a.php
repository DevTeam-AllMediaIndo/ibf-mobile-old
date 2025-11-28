<?php
    echo date("N", strtotime('+1 week')).'<hr>';
    echo date("Y-m-d").'<hr>';
    if(date("N") == 6){
        $date_start = date("Y-m-d", strtotime('+2 day'));
    };
    if(date("N") == 7){
        $date_start = date("Y-m-d", strtotime('+1 day'));
    };

    
    if(date("N", strtotime('+1 week')) == 6){
        $date_end = date("Y-m-d", strtotime('+6 day'));
    };
    if(date("N", strtotime('+1 week')) == 7){
        $date_end = date("Y-m-d", strtotime('+5 day'));
    };

    echo $date_start;
    echo '<hr>';
    echo $date_end;
?>