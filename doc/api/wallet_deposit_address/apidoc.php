<?php

class api_wallet_deposit_address {
    
    static function get_description() {
        return "Returns a new, unused wallet address for deposit purposes.";
    }
    
    static function get_params() {
        return [
                ['param' => 'force_unique', 'type' => 'bool', 'desc' => 'if true each address will be given out only once.  else unused addresses may be given out multiple times to avoid hd-wallet gaps', 'required' => false, 'values' => 'true | false', 'default' => 'false'],
               ];
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/wallet_deposit_address',
                          'response' => <<< END
"14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3"
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