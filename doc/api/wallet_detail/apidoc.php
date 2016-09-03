<?php

class api_wallet_detail {
    
    static function get_description() {
        return "Returns wallet info.  balance, etc.";
    }
    
    static function get_params() {
        return [];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_detail',
                          'response' => <<< END
{
    "available_balance": 1.5623,
    "reserved_balance": 0.32,
    "locked_balance": 0.0125
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