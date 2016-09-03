<?php

class api_market_list {
    
    static function get_description() {
        return "Returns list of all markets.";
    }
    
    static function get_params() {
        return [];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/market_list',
                          'response' => <<< END
[
    {
        "pair": "dash_btc",
        "lsymbol": "DASH",
        "rsymbol": "BTC",
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