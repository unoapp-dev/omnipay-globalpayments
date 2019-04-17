<?php

namespace Omnipay\GlobalPayments\Message;

class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->getCard()->validate();
        if ($this->getCard()) {

            $timestamp  = strftime("%Y%m%d%H%M%S");
            $merchantId  = $this->getMerchantId();
            $payerref  = $this->getprofileId();
            $cardref  = 'card'.$timestamp;
            $orderId  = $payerref.'-'.$timestamp;
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

            $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $amount. '.' . $currency. '.' . $payerref. '.' . $chname. '.' . $cardnumber;
            $temp2 = sha1($tmp1) . '.' . $secret;
            $sha1hash =  sha1($temp2);

            $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="card-new" timestamp="'.$timestamp.'"></request>');
            $request->addChild('merchantid', $this->getMerchantId());
            $request->addChild('account', $this->getAccount());
            $request->addChild('orderid',$orderId);
            $req_card = $request->addChild('card');
            $req_card->addChild('ref', $cardref);
            $req_card->addChild('payerref', $payerref);
            $req_card->addChild('number', $cardnumber);
            $req_card->addChild('expdate', $expdate);
            $req_card->addChild('chname', $chname);
            $req_card->addChild('type', $type);
            $request->addChild('sha1hash',$sha1hash);
            $data = $request->asXML();

        }
        return preg_replace('/\n/', ' ', $data);
    }
}
