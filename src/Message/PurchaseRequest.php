<?php

namespace Omnipay\GlobalPayments\Message;

use Omnipay\Common\Exception\InvalidRequestException;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;
        $this->validate('amount');
        $paymentMethod = $this->getPaymentMethod();
        switch ($paymentMethod)
        {
            case 'card' :
                break;
            case 'payment_profile' :
                if ($this->getCardReference()) {

                    $profileData = json_decode($this->getCardReference());
                    $timestamp  = strftime("%Y%m%d%H%M%S");
                    $merchantId  = $this->getMerchantId();
                    $payerRef  = $profileData->payer_ref;
                    $cardRef  = $profileData->card_ref;
                    $orderId  = $this->getOrderNumber();
                    $amount  = (int) ($this->getAmount() * 100);
                    $currency  = $this->getMerchantCurrency();
                    $secret  = $this->getsharedSecret();


                    $tmp1 = $timestamp . '.' . $merchantId . '.' . $orderId . '.' . $amount. '.' . $currency. '.' . $payerRef;
                    $temp2 = sha1($tmp1) . '.' . $secret;
                    $sha1hash =  sha1($temp2);

                    $request = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>
<request type="receipt-in" timestamp="'.$timestamp.'"></request>');
                    $request->addChild('merchantid', $this->getMerchantId());
                    $request->addChild('account', $this->getAccount());
                    $request->addChild('channel', $this->getChannel());
                    $request->addChild('orderid',$orderId);
                    $req_amount = $request->addChild('amount',$amount);
                    $req_amount->addAttribute('currency', $currency);
                    $req_falg = $request->addChild('autosettle');
                    $req_falg->addAttribute('flag', 1);
                    $request->addChild('payerref', $payerRef);
                    $request->addChild('paymentmethod', $cardRef);
                    $request->addChild('sha1hash',$sha1hash);
                    $data = $request->asXML();
                }
                break;
            case 'token' :
                break;
            default :
                break;
        }
        return preg_replace('/\n/', ' ', $data);
    }
}

