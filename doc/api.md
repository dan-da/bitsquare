
# Bitsquare API Specification

```
Author: Dan Libby <dan@osc.co.cr>
API Version: 1.0-draft-1
Created: 2016-08-19
Last Updated: 2016-08-19
```

## Motivation

A bitsquare API will enable individuals to automate the trading process.

Compared to the status quo (all trades are manual) autonomous agents (bots)
should lead to faster trades. Additionally custom agents may be written that
make trading decisions based on available market data.


## API Framework.

The API is part of the bitsquare application and may be accessed by making
REST requests directly to bitsquare running on localhost.

REST was chosen over pure json-rpc because it simplifies development and
debugging of client apps when developers can easily try out APIs directly in a
web browser or via curl.

Authentication is performed via HTTP Basic Auth.  An RPC username and password
must be configured or the RPC service will not be available. By default, access
is only allowed via localhost. This API is intended for use in trusted
environments only.  This closely mirrors the security model of the bitcoin-core
RPC API.

### Errors

APIs will return an error struct on any error.  The error struct looks like:

```
{
    "error": true,
    "code: <int>,
    "message": <string>
}
```

Results from successful API calls will not contain the "error" key, or if
present the value will be false.

Therefore, an error can be detected by checking that the error key exists and is
set to true.

#### Pre-defined error codes:
code | meaning
-----|--------
100 | method not found
200 | missing or invalid parameter
300 | internal processing error



## API RPC Methods

### Currencies

---

#### currency_list

Returns list of all currencies.

**Params**

<table><tr><td>None</td></tr></table>

**Example Return**

```
[
    {
        "symbol": "ETH",
        "name": "Ethereum",
        "type": "crypto"
    },
    {
        "symbol": "EUR",
        "name": "Euro",
        "type": "fiat"
    },
    ...
]
```

### Markets

#### market_list

Returns list of all markets

**Params**
<table><tr><td>None</td></tr></table>

**Example Return**

[
    {
        "pair": "dash_btc",
        "lsymbol": "DASH",
        "rsymbol": "BTC",
    },
    ...
]


### Wallet

---

#### wallet_detail

Returns wallet info.  balance, etc.

**Params**
<table><tr><td>None</td></tr></table>

**Example Return**

```
{
    "balance": 0.5623,
    // TBD
}
```

---

#### wallet_tx_list

Returns list of wallet transactions according to criteria

Param |  Type     | Required? | Default | Description
------|-----------|-----------|---------|---------------
start | timestamp | no        | 0       | start of period
end   | timestamp | no        | INT_MAX | end of period
limit | int       | no        | 100     | maximum records to return.


**Example Return**

```
{
    "amount": 1.3453,
    "type": "send",
    "address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
    "time": <timestamp>,
    "confirmations": 5
    // TBD
}
```


---

#### wallet_deposit_address

Returns a new, unused wallet address for deposit purposes.

**Params**
<table><tr><td>None</td></tr></table>

**Example Return**

```
"14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3"
```


---

#### wallet_send

Sends BTC funds from wallet to any bitcoin address.

Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|---------|---------------
address  | string        | yes       |         | recipient address
amount   | int           | yes       | INT_MAX | amount to send.

**Example Return**

```
<btc txid>
```



---

#### wallet_fund_offer

Moves BTC funds from internal wallet to offer, at time of offer creation.
Returns an error if insufficient funds in wallet.
    
Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|---------|---------------
offer_id | string        | yes       |         | Identifies the offer to fund.

**Example Return**

```
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "funded": true,
    "funds-moved": 1.342
}
```

TBD: Is there a blockchain txid associated with this movement, or bitsquare
transfer ID?


#### wallet_fund_offer_acceptance

Moves BTC funds from internal wallet to offer, at time of accepting an offer.
Returns an error if insufficient funds in wallet.
    
Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|---------|---------------
offer_id | string        | yes       |         | Identifies the offer to fund.

**Example Return**

```
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "accepted": true,
    "funds-moved": 1.342
}
```

NOTE: See offer_accept

### Accounts

---

#### account_list

    Lists my accounts.

**Params**
<table><tr><td>None</td></tr></table>

**Example Return**

```
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
            "max-trade-duration: 345600,
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

Note: The keys used inside the "method_detail" will vary depending on the
value of "payment_method".  All other keys are always present.

TODO: document all payment methods.


### Offers

---

#### offer_detail

Returns details of a specific offer.
    
Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|-----------|-------------
offer_id | string        | yes       |           | offer identifier

**Example Return**

```
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3"
    "side": "sell",
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

See notes for offer_list
    

---

#### offer_create

Create a new, unfunded offer.
(Offer must be funded before it can be published.)

Param          |  Type         | Required? | Default | Description
---------------|---------------|-----------|-----------|-------------
side           | string        | yes       |           | "sell" | "buy"
btc_amount     | string        | yes       |           | bitcoin amount
min_btc_amount | string        | yes       |           | minimum trade size to accept
price-type     | string        | yes       |           | "fixed" | "percentage"
price          | string        | yes       |           | interpreted according to "price-type".  Percentages should be expressed in decimal form eg 1/2 of 1% = "0.005"

**Example Return**

```
{
    "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3",
    "deposit_amount": 0.0107,
    "deposit_address": "14w4mZx4b6JjtEd9BZPnLCSXzbHjKH3Pn3",
    "detail": {
        "security_deposit": 0.01,
        "trade_fee": 0.0005,
        "mining_fee": 0.0002
    }
}
```

NOTE: full details about the offer can be retrieved with offer_detail.

---

#### offer_accept

Accept an existing offer.


Param          |  Type         | Required? | Default | Description
---------------|---------------|-----------|-----------|-------------
offer_id       | string        | yes       |           | Identifies offer to accept.


**Example Return**

```
{
    "offer_id": "1345132452341234322341234",
    "deposit_amount": 1.0103,
    "deposit_address": "12gWwt6bRDDEa6BJPkWoYpn2aoq8ayhFe9",
    "detail": {
        "trade_amount": 1,
        "security_deposit": 0.01,
        "trade_fee": 0.0001,
        "mining_fee": 0.0002
    }
}
```

NOTE: "trade_amount" may or may not be present depending on which side of the trade
the API caller is on.  ( Present when buying BTC.  Absent when selling. )

NOTE: The trade can be funded by sending payment from an external wallet or
by calling wallet_fund_offer_acceptance.

NOTE: The offer is not considered accepted until funds are received.


---

#### offer_cancel

Param          |  Type         | Required? | Default | Description
---------------|---------------|-----------|-----------|-------------
offer_id       | string        | yes       |           | Identifies offer to cancel


**Example Return**

```
true
```

TBD:  other info should be returned related to refund?

---

#### offer_list

Lists offers according to selection criteria.
    
Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|-----------|-------------
market   | string        | no        | all       | <market> or "all"
status   | string        | no        | all       | "unfunded" | "live" | "done" | "cancelled" | "all"
whose    | string        | no        | all       | "mine" | "notmine" | "all"
start    | timestamp     | no        | 0         | start time. seconds since 1970.
end      | timestamp     | no        | MAX_INT   | end time. seconds since 1970.
limit    | int           | no        | 100       | max records to return.

**Example Return**

```
[
    {
        "offer_id": "f6dab9d5-163f-4c2a-9c35-2d4c54da82e3"
        "side": "sell",
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

Note: price-detail/type may be "percentage" or "fixed".  If percentage, then
the value of "price" may change from call-to-call depending on the current value
of "market-price". If "fixed", then price is static and the price-detail/percent
key will not be present.

NOTE: when status == "done", there will now exist a trade with the same
trade_id as the offer_id.

TBD:  Can we give trade its own trade_id distinct from offer_id?  seems cleaner.


### Trades

==============================================

Trades section is incomplete.

TBD: We need a way to indicate trade status / events.

BUY-BTC side needs to know:
 1. when/how to send funds to counterparty.
 2. when counterparty has acknowledged receipt.
 3. if arbitration is occurring.
 4. when trade is complete.

SELL-BTC side needs to know: 
 1. when counterparty has sent funds, so I can confirm received.
 2. if arbitration is occurring.
 3. when trade is complete.


==============================================

---

#### trade_detail

Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|-----------|-------------
trade_id | string        | yes       |           | trade identifier


Returns details of a trade.

```    
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
    "offer_id": "3c6502f3-057e-454d-8ac5-8430f75b97c4"
}
---


#### trade_inform_sent

Informs bitsquare that payment has been sent.

Param    |  Type         | Required? | Default | Description
---------|---------------|-----------|-----------|-------------
trade_id | string        | no        | all       | <market> or "all"


---

#### trade_inform_received

Inform bitsquare that payment has been received.

---

#### trade_list

Lists trades according to selection criteria. ( mine/notmine/all, market/all, start, end, limit )


