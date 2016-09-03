<?php

class api_offer_detail {
    
    static function get_description() {
        return "Returns details of a specific offer.";
    }
    
    static function get_params() {
        return [
                ['param' => 'offer_id', 'type' => 'string', 'desc' => 'Identifies the offer', 'required' => true, 'values' => null, 'default' => null],
               ];
    
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/offer_detail?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3',
                          'response' => <<< END
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "direction": "sell",
    "status": "live",
    "funding": {
        "deposit_amount": 0.01,
        "deposit_address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
        "tx-list": [
            {
                "txid": "a8fe8f3f76cf28487be20fe5030243ac12348cd4033450414de7a4670bb0fb89",
                "confirmations": 3
            }
        ]
    },    
    "btc_amount": 1.0,
    "min_btc_amount": 0.2,
    "other_amount": 230,
    "price": 232.3,
    "price-detail": {
        "type": "percentage",
        "percent": 0.01,
        "market-price": 230
    },
    "created": 1471632887,
    "deposit": 0.01,
    "offerer": "a2wt75feadp232wx.onion:9999",
    "arbitrators": [
        "pkfcmj42c6es6tjt.onion:9999",
        "ntjhaj27rylxwvnp.onion:9999"
    ]
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["Returns an error if insufficient funds in wallet."];
    }
    
    static function get_seealso() {
        return ['offer_list'];
    }
}