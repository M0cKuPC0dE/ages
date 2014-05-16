<?php

class StreamsterApi {

    var $api;

    function StreamsterApi() {
        $this->api = new SoapClient("http://127.0.0.1:8018/service.wsdl", array('features' => SOAP_SINGLE_ELEMENT_ARRAYS));
    }

    /* ################################
     * Market Function
     * ################################
     */

    function getBars() {
        $r = $this->api->GetBars("EUR/USD", "5 minutes", "f");
        
        if (property_exists($r, "Bar")) {
            foreach ($r->Bar as $n => $Bar) {
                echo $n ." " . $Bar->BarDateTime . " " . $Bar->Open . " " . $Bar->High . " " . $Bar->Low . " " . $Bar->Close . "\n";
            }
        }

        return $r;
    }

    function getQuote() {
        $quote = $this->api->GetQuote("EUR/USD");
        echo $quote->Last . "\n";

        foreach ($quote as $field => $value) {
            echo $field . " = " . $value . "\n";
        }
    }

    /* ################################
     * Port Function
     * ################################
     */

    function getDesks() {
        $r = $this->api->GetDesks();
        if (property_exists($r, "Desk")) {
            foreach ($r->Desk as $n => $Desk) {
                echo "Number: " . $n;
                echo "Name: " . $Desk->Name;
                echo ", Currency: " . $Desk->Currency;
                echo ", Amount: " . $Desk->Amount;
                echo "\n";
            }
        }
    }

    function getOrders() {
        $r = $this->api->GetOrders();
        if (property_exists($r, "Order")) {
            foreach ($r->Order as $n => $OrderInfo) {
                echo "\tOrder " . $n . "\n";
                foreach ($OrderInfo as $field => $value) {
                    echo "\t\tField: " . $field . " = " . $value . "\n";
                }
            }
        }
    }

    /* ################################
     * Order Function
     * ################################
     */

    /* ################################
     * Extract Function
     * ################################
     */

    function getCloseFromBars() {
        if (property_exists($this->getBars(), "Bar")) {
            foreach ($this->getBars()->Bar as $n => $Bar) {
                $arr[$n] = $Bar->Close;
            }
        }
        return $arr;
    }

    /* ################################
     * Trader Function
     * ################################
     */

    function getSMA($period) {
        $result = trader_sma($this->getCloseFromBars(), $period);
        //print_r($result);
        return $result;
    }

    function getEMA($period) {
        $result = trader_ema($this->getCloseFromBars(), $period);
        //print_r($result);
        return $result;
    }

}
