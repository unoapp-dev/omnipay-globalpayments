<?php

namespace Omnipay\GlobalPayments\Message;

class DeleteCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->validate('cardReference');
        if ($this->getCardReference()) {

            $profileData = json_decode($this->getCardReference());
            $timestamp  = strftime("%Y%m%d%H%M%S");
            $merchantId  = $this->getMerchantId();
            $payerRef  = $profileData->payer_ref;
            $cardRef  = $profileData->card_ref;
            $orderId  = $payerRef.'-'.$timestamp;
            $secret  = $this->getsharedSecret();

            $tmp1 = $timestamp . '.' . $merchantId . '.' . $payerRef. '.' . $cardRef;
            $temp2 = sha1($tmp1) . '.' . $secret;
            $sha1hash =  sha1($temp2);

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="card-cancel-card" timestamp="'.$timestamp.'"></request>');
            $request->addChild('merchantid', $this->getMerchantId());
            $request->addChild('account', $this->getAmount());
            $request->addChild('orderid',$orderId);
            $req_card = $request->addChild('card');
            $req_card->addChild('ref', $cardRef);
            $req_card->addChild('payerref', $payerRef);
            $request->addChild('sha1hash',$sha1hash);
            $data = $request->asXML();

        }
        return preg_replace('/\n/', ' ', $data);
    }
}
