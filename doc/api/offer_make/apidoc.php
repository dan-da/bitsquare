<?php

class api_offer_make {
    
    static function get_description() {
        return "Make (create) a new, unfunded offer.";
    }
    
    static function get_params() {
        return [
                ['param' => 'market', 'type' => 'string', 'desc' => 'identifies the market this offer will be placed in', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'account_id', 'type' => 'string', 'desc' => 'identifies the account to which funds will be received once offer is executed.', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'direction', 'type' => 'string', 'desc' => 'defines if this is an offer to buy or sell', 'required' => true, 'values' => 'sell | buy', 'default' => null],
                ['param' => 'amount', 'type' => 'real', 'desc' => 'amount to buy or sell, in terms of left side of market pair', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'min_amount', 'type' => 'real', 'desc' => 'minimum amount to buy or sell, in terms of left side of market pair', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'price_type', 'type' => 'string', 'desc' => 'defines if this is a fixed offer or a percentage offset from present market price.', 'required' => false, 'values' => 'fixed | percentage', 'default' => 'fixed'],
                ['param' => 'price', 'type' => 'string', 'desc' => 'interpreted according to "price-type".  Percentages should be expressed in decimal form eg 1/2 of 1% = "0.005" and must be positive', 'required' => true, 'values' => null, 'default' => null],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/offer_create?market=xmr_btc&direction=buy&amount=1.2&min_amount=0.25&price=0.01925',
                          'response' => <<< END
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "deposit_amount": "0.0107",
    "deposit_address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
    "detail": {
        "direction": "buy",
        "amount": "1.2",
        "min_amount": "0.25",
        "price": "0.01925",
        "security_deposit": "0.01",
        "trade_fee": "0.0005",
        "mining_fee": "0.0002",
    }
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["The offer must be funded before it will be placed in offer book",
                "Funding can be done from Bitsquare internal wallet by calling wallet_fund_offer_internal, or from an external wallet by sending 'deposit_amount' to 'deposit_address'",
                "full details about the offer can be retrieved with offer_detail.",
                "'account_id' must refer to an account denominated in the same currency as 'market'",
                ];
    }
    
    static function get_seealso() {
        return ['wallet_fund_offer_internal', 'offer_detail', 'offer_take'];
    }
}