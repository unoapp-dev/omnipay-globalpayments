<?php

namespace Omnipay\GlobalPayments\Message;

use Omnipay\Common\Exception\InvalidRequestException;
class RefundRequest extends AbstractRequest
{

    public function getData()
    {

        $data = null;
        $this->validate('amount');

        $transactionReference = simplexml_load_string($this->getTransactionReference());
        $timestamp  = strftime("%Y%m%d%H%M%S");
        $merchantId  = $this->getMerchantId();
        $orderId  = $transactionReference->orderid;
        $pasref  = $transactionReference->pasref;
        $authcode  = $transactionReference->authcode;
        $amount  = (int) ($this->getAmount() * 100);
        $currency  = $this->getMerchantCurrency();
        $cardnumber  = '';
        $rebatepass  = $this->getrebatePassword();
        $secret  = $this->getsharedSecret();


        $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $amount. '.' . $currency. '.' . $cardnumber;
        $temp2 = sha1($tmp1) . '.' . $secret;
        $sha1hash =  sha1($temp2);
        $refundhash =  sha1($rebatepass);

        $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="rebate" timestamp="'.$timestamp.'"></request>');
        $request->addChild('merchantid', $this->getMerchantId());
        $request->addChild('account', $this->getAccount());
        $request->addChild('orderid',$orderId);
        $req_amount = $request->addChild('amount',$amount);
        $req_amount->addAttribute('currency', $currency);
        $request->addChild('pasref', $pasref);
        $request->addChild('authcode', $authcode);
        $request->addChild('refundhash', $refundhash);
        $request->addChild('sha1hash',$sha1hash);
        $data = $request->asXML();
        return preg_replace('/\n/', ' ', $data);

    }
}
