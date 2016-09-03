<?php

class api_wallet_tx_list {
    
    static function get_description() {
        return "Returns list of wallet transactions according to criteria";
    }
    
    static function get_params() {
        return [
                ['param' => 'type', 'type' => 'string', 'desc' => 'transaction type', 'required' => false, 'values' => 'send | receive', 'default' => '0'],
                ['param' => 'start', 'type' => 'longint', 'desc' => 'start of period', 'required' => false, 'values' => null, 'default' => '0'],
                ['param' => 'end', 'type' => 'longint', 'desc' => 'end of period', 'required' => false, 'values' => null, 'default' => 'INT_MAX'],
                ['param' => 'limit', 'type' => 'int', 'desc' => 'max record to return', 'required' => false, 'values' => null, 'default' => 100],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_tx_list',
                          'response' => <<< END
{
    "amount": 1.3453,
    "type": "send",
    "address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
    "time": <timestamp>,
    "confirmations": 5,
    "txid": "e169edeeb8fa2cfc6c341a0c3f0b8f505f3e1984c7de8c22ea047bcf074862fe",
    "detail": "Withdrawn from wallet"
    // TBD
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return [];
    }
    
    static function get_seealso() {
        return [];
    }
}