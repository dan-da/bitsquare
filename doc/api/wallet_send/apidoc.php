<?php

class api_wallet_send {
    
    static function get_description() {
        return "Sends BTC funds from wallet to any bitcoin address.";
    }
    
    static function get_params() {
        return [
                ['param' => 'address_payto', 'type' => 'string', 'desc' => 'recipient address', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'amount', 'type' => 'real', 'desc' => 'amount to send', 'required' => true, 'values' => null, 'default' => null],
                ['param' => 'address_sources', 'type' => 'csvstring', 'desc' => 'one or more source addresses, for coin control.  If omitted, addresses will be automatically chosen', 'required' => false, 'values' => null, 'default' => null],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_send?address=14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3&amount=1.55',
                          'response' => <<< END
"<btc txid>"
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ['a list of funded addresses is available via the wallet_addresses api'];
    }
    
    static function get_seealso() {
        return ['wallet_addresses'];
    }
}