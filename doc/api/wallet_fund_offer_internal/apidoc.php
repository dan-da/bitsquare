<?php

class api_wallet_fund_offer_internal {
    
    static function get_description() {
        return "Moves BTC funds from internal wallet to offer, at time of offer creation.";
    }
    
    static function get_params() {
        return [
                ['param' => 'offer_id', 'type' => 'string', 'desc' => 'Identifies the offer to fund', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'source_address', 'type' => 'string', 'desc' => 'identifies bitcoin source address for coin selection.  if omitted, an address will be selected automatically.', 'required' => false, 'values' => null, 'default' => null],
               ];
    
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_fund_offer?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3',
                          'response' => <<< END
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "funded": true,
    "funds_moved": 1.342,
    "source_address": "<btc addr>"
}
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["Returns an error if insufficient funds in wallet.",
                "TBD: mk mentioned something about states: undefined, fee_paid, available."];
    }
    
    static function get_seealso() {
        return ['offer_make', 'offer_take'];
    }
}