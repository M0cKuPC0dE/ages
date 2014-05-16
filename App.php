<?php

include 'StreamsterApi.php';

$api = new StreamsterApi();

$close = $api->getCloseFromBars();

$ema10 = trader_ema($close, 10);
$ema50 = trader_ema($close, 50);

for ($i = 50; $i < sizeof($close); $i++) {
    echo "Close : " . $close[$i] . " , EMA10 : " . $ema10[$i] . " , EMA50 : " . $ema50[$i] . "\r\n";
    if ($ema10[$i] >= $ema50[$i] && $ema10[$i-1] <= $ema50[$i-1]) {
        echo $i." #### Cut UP\r\n";
    }
}

//for($i = 0; $i < sizeof($close)-49;$i++){
//    $r10 = array_slice($ema50, 0, 50+$i);
//    echo sizeof($r10)."\r\n";
//}
//$cur10Index =  sizeof($ema10)-1;
//$last10Index = $cur10Index -1;
//$cur50Index =  sizeof($ema50)-1;
//$last50Index = $cur50Index - 1;
//
//if ($cur10Index > $last10Index && $cur10Index > $cur50Index && $last10Index < $last50Index) {
//    echo "cut\r\n";
//}

