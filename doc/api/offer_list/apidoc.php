<?php

class api_offer_list {
    
    static function get_description() {
        return "Lists offers according to selection criteria.";
    }
    
    static function get_params() {
        return [
                ['param' => 'market', 'type' => 'string', 'desc' => 'filter by market', 'required' => false, 'values' => '<market> | "all"', 'default' => 'all'],
                ['param' => 'status', 'type' => 'string', 'desc' => 'filter by status', 'required' => false, 'values' => '"unfunded" | "live" | "done" | "cancelled" | "all"', 'default' => 'all'],
                ['param' => 'whose', 'type' => 'string', 'desc' => 'filter by offer creator', 'required' => false, 'values' => '"mine" | "notmine" | "all"', 'default' => 'all'],
                ['param' => 'start', 'type' => 'longint', 'desc' => 'find offers after start time. seconds since 1970.', 'required' => false, 'values' => null, 'default' => 0],
                ['param' => 'end', 'type' => 'longint', 'desc' => 'find offers before end time. seconds since 1970.', 'required' => false, 'values' => null, 'default' => PHP_INT_MAX],
                ['param' => 'limit', 'type' => 'int', 'desc' => 'max records to return', 'required' => false, 'values' => null, 'default' => 100],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/offer_list?market=xmr_btc&whose=mine',
                          'response' => <<< END
[
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
        "offerer": "a2wt75feadp232wx.onion:9999",
        "arbitrators": [
            "pkfcmj42c6es6tjt.onion:9999",
            "ntjhaj27rylxwvnp.onion:9999"
        ]
    }
    ...
]
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return [
            'price-detail/type may be "percentage" or "fixed".  If percentage, then
the value of "price" may change from call-to-call depending on the current value
of "market-price". If "fixed", then price is static and the price-detail/percent
key will not be present.',

            'when status == "done", there will now exist a trade with the same
trade_id as the offer_id.',

            'TBD: Can we give trade its own trade_id distinct from offer_id?  seems cleaner.',
               ];
    }
    
    static function get_seealso() {
        return ['offer_detail'];
    }
}