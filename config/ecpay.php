<?php
return [
    'MerchantId' => env('ECPAY_MERCHANT_ID', '3148310'),
    'HashKey' => env('ECPAY_HASH_KEY', '5bT9JGtACsS1Ed2j'),
    'HashIV' => env('ECPAY_HASH_IV', 'H80tHd4inW4UsqxK'),
    'InvoiceHashKey' => env('ECPAY_INVOICE_HASH_KEY', ''),
    'InvoiceHashIV' => env('ECPAY_INVOICE_HASH_IV', ''),
    'SendForm' => env('ECPAY_SEND_FORM', null)
];