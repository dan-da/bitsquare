
# Bitsquare API Specification
```
Version: bitsquare-api-1.0.0-draft2
Authors: Dan Libby <dan@osc.co.cr>, Mike Rosseel <mike.rosseel@gmail.com>, Manfred Karrer <manfred@bitsquare.io> 
Created: 2016-08-19 
Last Updated: 2016-08-19 
```

## Intro
The API is part of the Bitsquare application and may be accessed by making
REST requests directly to bitsquare running on localhost.

REST was chosen over pure json-rpc because it simplifies development and
debugging of client apps when developers can easily try out APIs directly in a
web browser or via curl.

Authentication is performed via HTTP Basic Auth.  An RPC username and password
must be configured or the RPC service will not be available. By default, access
is only allowed via localhost. This API is intended for use in trusted
environments only.  This closely mirrors the security model of the bitcoin-core
RPC API.


## API List

* Account
  * [/api/account_list](#user-content-apiaccount_list)
* Currency
  * [/api/currency_list](#user-content-apicurrency_list)
* Market
  * [/api/market_list](#user-content-apimarket_list)
* Offer
  * [/api/offer_cancel](#user-content-apioffer_cancel)
  * [/api/offer_detail](#user-content-apioffer_detail)
  * [/api/offer_list](#user-content-apioffer_list)
  * [/api/offer_make](#user-content-apioffer_make)
  * [/api/offer_take](#user-content-apioffer_take)
* Trade
  * [/api/trade_detail](#user-content-apitrade_detail)
* Wallet
  * [/api/wallet_addresses](#user-content-apiwallet_addresses)
  * [/api/wallet_deposit_address](#user-content-apiwallet_deposit_address)
  * [/api/wallet_detail](#user-content-apiwallet_detail)
  * [/api/wallet_fund_offer_internal](#user-content-apiwallet_fund_offer_internal)
  * [/api/wallet_send](#user-content-apiwallet_send)
  * [/api/wallet_tx_list](#user-content-apiwallet_tx_list)
    
Error responses are documented [at bottom](#user-content-error-responses).
    

## /api/account_list

Lists my accounts.

### Sample Request

    http://localhost/api/account_list

### Sample Response
```json
[
    {
        "name": "National Bank Transfer 234332523, 23544351",
        "payment_method": "national_bank_transfer",
        "method_detail": {
            "country": "us",
            "currency": "USD",
            "account_holder_name": "John Doe",
            "routing_number": "23454352435",
            "account_number": "982353543-345234-323423",
            "account_type": "checking"
        },
        "limitations": {
            "max-trade-duration": 345600,
            "max-trade-limit": 1
        }
    },
    {
        "name": "Cryptocurrencies, XMR, 44AFFq5k...",
        "payment_method": "altcoins",
        "method_detail": {
            "address": "44AFFq5kSiGBoZ4NMDwYtN18obc8AemS33DBLWs3H7otXft3XjrpDtQGv7SqSsaBYBb98uNbr2VBBEt7f2wfn3RVGQBEP3A",
            "currency": "XMR"
        },
        "limitations": {
            "max-trade-duration: 345600,
            "max-trade-limit": 1
        }
    },
    ...
]
```

    
### Parameters

None

    
### Notes
* The keys used inside the 'method_detail' will vary depending on the value of 'payment_method'.  All other keys are always present.
* TODO: document all payment methods.
    
    

## /api/currency_list

Returns list of all currencies.

### Sample Request

    http://localhost/api/currency_list

### Sample Response
```json
[
    {
        "symbol": "ETH",
        "name": "Ethereum",
        "type": "crypto",
        "precision": 8,
        "display_precision": 8
    },
    {
        "symbol": "EUR",
        "name": "Euro",
        "type": "fiat",
        "precision": 8,
        "display_precision": 2
    },
    ...
]
```

    
### Parameters

None

    
    
    

## /api/market_list

Returns list of all markets.

### Sample Request

    http://localhost/api/market_list

### Sample Response
```json
[
    {
        "pair": "dash_btc",
        "lsymbol": "DASH",
        "rsymbol": "BTC",
    },
    ...
]
```

    
### Parameters

None

    
    
    

## /api/offer_cancel

Cancels an existing offer

### Sample Request

    http://localhost/api/offer_cancel?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3

### Sample Response
```json
true
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
offer_id|string|Identifies offer to cancel|1||


    
### Notes
* TBD:  other info should be returned related to refund?
    
    

## /api/offer_detail

Returns details of a specific offer.

### Sample Request

    http://localhost/api/offer_detail?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3

### Sample Response
```json
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
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
offer_id|string|Identifies the offer|1||


    
### Notes
* Returns an error if insufficient funds in wallet.
    
### See Also

* [offer_list](#user-content-apioffer_list)
    

## /api/offer_list

Lists offers according to selection criteria.

### Sample Request

    http://localhost/api/offer_list?market=xmr_btc&whose=mine

### Sample Response
```json
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
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
market|string|filter by market||<market> \| "all"|all
status|string|filter by status||"unfunded" \| "live" \| "done" \| "cancelled" \| "all"|all
whose|string|filter by offer creator||"mine" \| "notmine" \| "all"|all
start|longint|find offers after start time. seconds since 1970.|||0
end|longint|find offers before end time. seconds since 1970.|||9223372036854775807
limit|int|max records to return|||100


    
### Notes
* price-detail/type may be "percentage" or "fixed".  If percentage, then
the value of "price" may change from call-to-call depending on the current value
of "market-price". If "fixed", then price is static and the price-detail/percent
key will not be present.
* when status == "done", there will now exist a trade with the same
trade_id as the offer_id.
* TBD: Can we give trade its own trade_id distinct from offer_id?  seems cleaner.
    
### See Also

* [offer_detail](#user-content-apioffer_detail)
    

## /api/offer_make

Make (create) a new, unfunded offer.

### Sample Request

    http://localhost/api/offer_create?market=xmr_btc&direction=buy&amount=1.2&min_amount=0.25&price=0.01925

### Sample Response
```json
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
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
market|string|identifies the market this offer will be placed in|1||
account_id|string|identifies the account to which funds will be received once offer is executed.|1||
direction|string|defines if this is an offer to buy or sell|1|sell \| buy|
amount|real|amount to buy or sell, in terms of left side of market pair|1||
min_amount|real|minimum amount to buy or sell, in terms of left side of market pair|1||
price_type|string|defines if this is a fixed offer or a percentage offset from present market price.||fixed \| percentage|fixed
price|string|interpreted according to "price-type".  Percentages should be expressed in decimal form eg 1/2 of 1% = "0.005" and must be positive|1||


    
### Notes
* The offer must be funded before it will be placed in offer book
* Funding can be done from Bitsquare internal wallet by calling wallet_fund_offer_internal, or from an external wallet by sending 'deposit_amount' to 'deposit_address'
* full details about the offer can be retrieved with offer_detail.
* 'account_id' must refer to an account denominated in the same currency as 'market'
    
### See Also

* [wallet_fund_offer_internal](#user-content-apiwallet_fund_offer_internal)
* [offer_detail](#user-content-apioffer_detail)
* [offer_take](#user-content-apioffer_take)
    

## /api/offer_take

Take (accept) an existing offer.

### Sample Request

    http://localhost/api/offer_take?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3&account_id=6d4c54da82e3&amount=0.55

### Sample Response
```json
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
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
offer_id|string|Identifies the offer to accept|1||
account_id|string|Identifies the payment account to receive funds into|1||
amount|string|amount to spend|1||


    
### Notes
* "trade_amount" may or may not be present depending on caller's trade direction.  ( Present when buying BTC.  Absent when selling. )
* The trade can be funded by sending payment from an external wallet or by calling wallet_fund_offer_internal
* The offer is not considered taken until funds are received.
    
### See Also

* [wallet_fund_offer_internal](#user-content-apiwallet_fund_offer_internal)
* [offer_detail](#user-content-apioffer_detail)
* [offer_take](#user-content-apioffer_take)
    

## /api/trade_detail

Returns details of a specific trade, including trade status for maker and taker.

### Sample Request

    http://localhost/api/trade_detail?trade_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3

### Sample Response
```json
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
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
trade_id|string|Identifies the trade|1||


    
### Notes
* the status fields will be used for client's to poll while waiting for trade to complete.  Possibly we could make a separate (faster) API for this purpose.
    
    

## /api/wallet_addresses

Returns list of wallet addresses.

### Sample Request

    http://localhost/api/wallet_addresses?status=funded

### Sample Response
```json
[
    {
        "address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
        "balance": 1.3453
    },
    ...
]
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
status|string|filter by wether each address has a non-zero balance or not||funded \| unfunded \| both|both
start|int|starting index, zero based|||0
limit|int|max number of addresses to return.|||100


    
    
    

## /api/wallet_deposit_address

Returns a new, unused wallet address for deposit purposes.

### Sample Request

    http://localhost/api/wallet_deposit_address

### Sample Response
```json
"14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3"
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
force_unique|bool|if true each address will be given out only once.  else unused addresses may be given out multiple times to avoid hd-wallet gaps||true \| false|false


    
    
    

## /api/wallet_detail

Returns wallet info.  balance, etc.

### Sample Request

    http://localhost/api/wallet_detail

### Sample Response
```json
{
    "available_balance": 1.5623,
    "reserved_balance": 0.32,
    "locked_balance": 0.0125
    // TBD
}
```

    
### Parameters

None

    
    
    

## /api/wallet_fund_offer_internal

Moves BTC funds from internal wallet to offer, at time of offer creation.

### Sample Request

    http://localhost/api/wallet_fund_offer?offer_id=f6dab9d5-163f-4c2a-9c35-2d4c54da82e3

### Sample Response
```json
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "funded": true,
    "funds_moved": 1.342,
    "source_address": "<btc addr>"
}
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
offer_id|string|Identifies the offer to fund|1||
source_address|string|identifies bitcoin source address for coin selection.  if omitted, an address will be selected automatically.|||


    
### Notes
* Returns an error if insufficient funds in wallet.
* TBD: mk mentioned something about states: undefined, fee_paid, available.
    
### See Also

* [offer_make](#user-content-apioffer_make)
* [offer_take](#user-content-apioffer_take)
    

## /api/wallet_send

Sends BTC funds from wallet to any bitcoin address.

### Sample Request

    http://localhost/api/wallet_send?address=14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3&amount=1.55

### Sample Response
```json
"<btc txid>"
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
address_payto|string|recipient address|1||
amount|real|amount to send|1||
address_sources|csvstring|one or more source addresses, for coin control.  If omitted, addresses will be automatically chosen|||


    
### Notes
* a list of funded addresses is available via the wallet_addresses api
    
### See Also

* [wallet_addresses](#user-content-apiwallet_addresses)
    

## /api/wallet_tx_list

Returns list of wallet transactions according to criteria

### Sample Request

    http://localhost/api/wallet_tx_list

### Sample Response
```json
{
    "amount": 1.3453,
    "type": "send",
    "address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
    "time": <timestamp>,
    "confirmations": 5,
    "txid": "e169edeeb8fa2cfc6c341a0c3f0b8f505f3e1984c7de8c22ea047bcf074862fe",
    "detail": "Withdrawn from wallet"
    // TBD
}
```

    
### Parameters


param|type|desc|required|values|default
-----|----|----|--------|------|-------
type|string|transaction type||send \| receive|0
start|longint|start of period|||0
end|longint|end of period|||INT_MAX
limit|int|max record to return|||100


    
    
    

## Error Responses

APIs will return an error struct on any error.  The error struct looks like:
```json
{
    "error": true,
    "code: 100,
    "message": <string>
}
```

Results from successful API calls will not contain the "error" key, or if present the value will be false.

Therefore, an error can be detected by checking that the error key exists and is set to true.