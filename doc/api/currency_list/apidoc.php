<?php

class api_currency_list {
    
    static function get_description() {
        return "Returns list of all currencies.";
    }
    
    static function get_params() {
        return [];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/currency_list',
                          'response' => <<< END
[
    {
        "symbol": "ETH",
        "name": "Ethereum",
        "type": "crypto",
        "precision": 8,
        "display_precision": 8
    },
    {
        "symbol": "EUR",
        "name": "Euro",
        "type": "fiat",
        "precision": 8,
        "display_precision": 2
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