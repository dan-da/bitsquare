<?php

class api_offer_take {
    
    static function get_description() {
        return "Take (accept) an existing offer.";
    }
    
    static function get_params() {
        return [
                ['param' => 'offer_id', 'type' => 'string', 'desc' => 'Identifies the offer to accept', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'account_id', 'type' => 'string', 'desc' => 'Identifies the payment account to receive funds into', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'amount', 'type' => 'string', 'desc' => 'amount to spend', 'required' => true, 'values' => null, 'default' => null],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/offer_take?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3&account_id=6d4c54da82e3&amount=0.55',
                          'response' => <<< END
{
    "offer_id": "1345132452341234322341234",
    "deposit_amount": 1.0103,
    "deposit_address": "12gWwt6bRDDEa6BJPkWoYpn2aoq8ayhFe9",
    "detail": {
        "account_id": "6d4c54da82e3",
        "trade_amount": "0.55",
        "security_deposit": 0.01,
        "trade_fee": 0.0001,
        "mining_fee": 0.0002
    }
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return [
                '"trade_amount" may or may not be present depending on caller\'s trade direction.  ( Present when buying BTC.  Absent when selling. )',
                'The trade can be funded by sending payment from an external wallet or by calling wallet_fund_offer_internal',
                'The offer is not considered taken until funds are received.',
                ];
    }
    
    static function get_seealso() {
        return ['wallet_fund_offer_internal', 'offer_detail', 'offer_take'];
    }
}