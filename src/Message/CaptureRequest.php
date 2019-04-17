<?php

namespace Omnipay\GlobalPayments\Message;

class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        if ($this->getTransactionReference()) {

            $transactionReference = simplexml_load_string($this->getTransactionReference());
            $timestamp  = strftime("%Y%m%d%H%M%S");
            $merchantId  = $this->getMerchantId();
            $orderId  = $transactionReference->orderid;
            $pasref  = $transactionReference->pasref;
            $amount  = '';
            $currency  = '';
            $cardnumber  = '';
            $secret  = $this->getsharedSecret();


            $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $amount. '.' . $currency. '.' . $cardnumber;
            $temp2 = sha1($tmp1) . '.' . $secret;
            $sha1hash =  sha1($temp2);

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="settle" timestamp="'.$timestamp.'"></request>');
            $request->addChild('merchantid', $this->getMerchantId());
            $request->addChild('account', $this->getAccount());
            $request->addChild('orderid',$orderId);
            $request->addChild('pasref', $pasref);
            $request->addChild('sha1hash',$sha1hash);
            $data = $request->asXML();
        }
        return preg_replace('/\n/', ' ', $data);
    }
}
