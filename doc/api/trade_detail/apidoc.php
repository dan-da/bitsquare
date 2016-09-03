<?php

class api_trade_detail {
    
    static function get_description() {
        return "Returns details of a specific trade, including trade status for maker and taker.";
    }
    
    static function get_params() {
        return [
                ['param' => 'trade_id', 'type' => 'string', 'desc' => 'Identifies the trade', 'required' => true, 'values' => null, 'default' => null],
               ];
    
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/trade_detail?trade_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3',
                          'response' => <<< END
{
    "trade_id": "5b6502f3-057e-454d-8ac5-8430f75b97c2",
    "market": "XMR/BTC",
    "direction": "BUY",
    "price": 2349100,
    "amount": 20000000,
    "trade_date": 1471701655737,
    "payment_method": "BLOCK_CHAINS",
    "offer_date": 1471689741937,
    "use_market_based_price": true,
    "market_price_margin": 0.015,
    "offer_amount": 20000000,
    "offer_min_amount": 20000000,
    "deposit_tx_id": "8e4801f91fea301740c35fe1dbce918d94510d33f8ca484652838bc76c687817",
    "offer_id": "3c6502f3-057e-454d-8ac5-8430f75b97c4",
    "status": {
        "maker": // TODO
        "taker": // TODO
    }
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["the status fields will be used for client's to poll while waiting for trade to complete.  Possibly we could make a separate (faster) API for this purpose."];
    }
    
    static function get_seealso() {
        return [];
    }
}