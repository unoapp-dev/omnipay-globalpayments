<?php

namespace Omnipay\GlobalPayments\Message;

class ValidateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->getCard()->validate();
        if ($this->getCard()) {

            $timestamp  = strftime("%Y%m%d%H%M%S");
            $merchantId  = $this->getMerchantId();
            $orderId  = 'validate-'.$timestamp;
            $amount  = '';
            $currency  = '';
            $secret  = $this->getsharedSecret();
            $chname  = $this->getCard()->getName();
            $brand = array(
                "visa" => "VISA",
                "mastercard" => "MC",
                "amex" => "AMEX",
                "diners_club" => "DINERS",
                "discover" => "DISCOVER",
                "jcb" => "JCB"
            );
            $cardnumber  = $this->getCard()->getNumber();
            $type  = $brand[$this->getCard()->getBrand()];
            $expdate  = $this->getCard()->getExpiryDate('my');
            $cvv  = $this->getCard()->getCvv();

            $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $cardnumber;
            $temp2 = sha1($tmp1) . '.' . $secret;
            $sha1hash =  sha1($temp2);

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="otb" timestamp="'.$timestamp.'"></request>');
            $request->addChild('merchantid', $this->getMerchantId());
            $request->addChild('account', $this->getAccount());
            $request->addChild('orderid',$orderId);
            $req_card = $request->addChild('card');
            $req_card->addChild('number', $cardnumber);
            $req_card->addChild('expdate', $expdate);
            $req_card->addChild('chname', $chname);
            $req_card->addChild('type', $type);
            $cvn_card = $request->addChild('cvn');
            $cvn_card->addChild('number',$cvv);
            $request->addChild('sha1hash',$sha1hash);
            $data = $request->asXML();
//            dd($data);
        }
        return preg_replace('/\n/', ' ', $data);
    }
}
