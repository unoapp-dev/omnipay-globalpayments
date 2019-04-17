<?php

namespace Omnipay\GlobalPayments\Message;

class CreateProfileRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        if ($this->getprofileId()) {
            $timestamp  = strftime("%Y%m%d%H%M%S");
            $merchantId  = $this->getMerchantId();
            $payerref  = $this->getprofileId();
            $orderId  = $payerref.'-'.$timestamp;
            $amount  = '';
            $currency  = '';
            $secret  = $this->getsharedSecret();

            $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $amount. '.' . $currency. '.' . $payerref;
            $temp2 = sha1($tmp1) . '.' . $secret;
            $sha1hash =  sha1($temp2);

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
            <request type="payer-new" timestamp="'.$timestamp.'"></request>');
            $request->addChild('merchantid', $merchantId);
            $request->addChild('account', $this->getAccount());
            $request->addChild('orderid',"$orderId");
            $req_payer = $request->addChild('payer');
            $req_payer->addAttribute('ref', $payerref);
            $req_payer->addAttribute('type', 'Retail');
            $request->addChild('sha1hash',$sha1hash);
            $data = $request->asXML();

        }
        return preg_replace('/\n/', ' ', $data);
    }
}
