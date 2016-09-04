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
        "account_id": "c4e4645a-18e6-45be-8853-c7ebac68f0a4",
        "created": 1473010076100,
        "payment_method": {
            "payment_method_id": "SEPA",
            "lock_time": 0,
            "max_trade_period": 691200000,
            "max_trade_limit": {
                "value": 75000000,
                "positive": true,
                "zero": false,
                "negative": false
            }
        },
        "account_name": "SEPA, EUR, BE, BE...",
        "trade_currencies": ['EUR'],
        "selected_trade_currency": 'EUR',
        "contract_data": {
            "payment_method_name": "SEPA",
            "contract_id": "c4e4645a-18e6-45be-8853-c7ebac68f0a4",
            "max_trade_period": 691200000,
            "country_code": "BE",
            "holder_name": "Mike Rosseel",
            "iban": "BE82063500018968",
            "bic": "GKCCBEBB",
            "accepted_country_codes": ["AT", "BE", "CY", "DE", "EE", "ES", "FI", "FR", "GR", "IE", "IT", "LT", "LU", "LV", "MC", "MT", "NL", "PT", "SI", "SK"],
            "payment_details": "SEPA - Holder name: Mike Rosseel, IBAN: BE82063500018968, BIC: GKCCBEBB, country code: BE",
            "payment_details_for_trade_popup": "Holder name: Mike Rosseel\nIBAN: BE82063500018968\nBIC: GKCCBEBB\nCountry of bank: Belgium (BE)"
        },
        "country": {
            "code": "BE",
            "name": "Belgium",
            "region": {
                "code": "EU",
                "name": "Europe"
            }
        },
        "accepted_country_codes": ["AT", "BE", "CY", "DE", "EE", "ES", "FI", "FR", "GR", "IE", "IT", "LT", "LU", "LV", "MC", "MT", "NL", "PT", "SI", "SK"],
        "bank_id": "GKCCBEBB",
        "iban": "BE82063500018968",
        "holder_name": "Mike Rosseel",
        "bic": "GKCCBEBB",
        "single_trade_currency": 'EUR',
        "payment_details": "SEPA - Holder name: Mike Rosseel, IBAN: BE82063500018968, BIC: GKCCBEBB, country code: BE"
    },
    ...
]
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["TODO: document which fields are constant for all account types."];
    }
    
    static function get_seealso() {
        return [];
    }
}