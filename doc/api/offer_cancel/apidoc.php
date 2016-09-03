<?php

class api_offer_cancel {
    
    static function get_description() {
        return "Cancels an existing offer";
    }
    
    static function get_params() {
        return [
                ['param' => 'offer_id', 'type' => 'string', 'desc' => 'Identifies offer to cancel', 'required' => true, 'values' => null, 'default' => null],
               ];
    
    }

    static function get_examples() {
        $examples = [];
        $examples[] = 
                        [ 'request' => '/offer_cancel?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3',
                          'response' => <<< END
true
END
                        ];
                        
        return $examples;
    }
    
    static function get_notes() {
        return ["TBD:  other info should be returned related to refund?"];
    }
    
    static function get_seealso() {
        return [];
    }
}