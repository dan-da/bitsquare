<?php

class api_account_list {
    
    static function get_description() {
        return "Lists my accounts.";
    }
    
    static function get_params() {
        return [];
    
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/account_list',
                          'response' => <<< END
[
    {
        "name": "National Bank Transfer 234332523, 23544351",
        "payment_method": "national_bank_transfer",
        "method_detail": {
            "country": "us",
            "currency": "USD",
            "account_holder_name": "John Doe",
            "routing_number": "23454352435",
            "account_number": "982353543-345234-323423",
            "account_type": "checking"
        },
        "limitations": {
            "max-trade-duration": 345600,
            "max-trade-limit": 1
        }
    },
    {
        "name": "Cryptocurrencies, XMR, 44AFFq5k...",
        "payment_method": "altcoins",
        "method_detail": {
            "address": "44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A",
            "currency": "XMR"
        },
        "limitations": {
            "max-trade-duration: 345600,
            "max-trade-limit": 1
        }
    },
    ...
]
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["The keys used inside the 'method_detail' will vary depending on the value of 'payment_method'.  All other keys are always present.",
                "TODO: document all payment methods."];
    }
    
    static function get_seealso() {
        return [];
    }
}