<?php

class api_wallet_addresses {
    
    static function get_description() {
        return "Returns list of wallet addresses.";
    }
    
    static function get_params() {
        return [
                ['param' => 'status', 'type' => 'string', 'desc' => 'filter by wether each address has a non-zero balance or not', 'required' => false, 'values' => 'funded | unfunded | both', 'default' => 'both'],
                ['param' => 'start', 'type' => 'int', 'desc' => 'starting index, zero based', 'required' => false, 'values' => null, 'default' => '0'],
                ['param' => 'limit', 'type' => 'int', 'desc' => 'max number of addresses to return.', 'required' => false, 'values' => null, 'default' => 100],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_addresses?status=funded',
                          'response' => <<< END
[
    {
        "address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
        "balance": 1.3453
    },
    ...
]
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