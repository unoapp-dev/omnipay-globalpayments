<?php

namespace  Omnipay\GlobalPayments\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $host = 'https://api.realexpayments.com/epage-remote.cgi';
    protected $testHost = 'https://api.sandbox.realexpayments.com/epage-remote.cgi';
    protected $endpoint = '';

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testHost : $this->host;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getMerchantId()
    {
        return $this->getParameter('merchantid');
    }

    public function setMerchantId($value)
    {
        return $this->setParameter('merchantid', $value);
    }

    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getChannel()
    {
        return $this->getParameter('channel');
    }

    public function setChannel($value)
    {
        return $this->setParameter('channel', $value);
    }

    public function getprofileId()
    {
        return $this->getParameter('profileId');
    }

    public function setprofileId($value)
    {
        return $this->setParameter('profileId', $value);
    }

    public function getsharedSecret()
    {
        return $this->getParameter('sharedSecret');
    }

    public function setsharedSecret($value)
    {
        return $this->setParameter('sharedSecret', $value);
    }

    public function getrebatePassword()
    {
        return $this->getParameter('rebatePassword');
    }

    public function setrebatePassword($value)
    {
        return $this->setParameter('rebatePassword', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getMerchantCurrency()
    {
        return $this->getParameter('merchantCurrency');
    }
    public function setMerchantCurrency($value)
    {
        return $this->setParameter('merchantCurrency', $value);
    }

    public function getCardHolderName()
    {
        return $this->getParameter('cardholdername');
    }

    public function setCardHolderName($value)
    {
        return $this->setParameter('cardholdername', $value);
    }

    public function getOrderNumber()
    {
        return $this->getParameter('order_number');
    }

    public function setOrderNumber($value)
    {
        return $this->setParameter('order_number', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'text/xml'
        ];
        if (!empty($data)) {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $data);
        }
        else {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);
        }
        try {
            $xmlResponse = simplexml_load_string($httpResponse->getBody()->getContents());
        }
        catch (\Exception $e){
            info('Guzzle response : ', [$httpResponse]);
            $res = [];
            $res['resptext'] = 'Oops! something went wrong, Try again after sometime.';
            return $this->response = new Response($this, $res);
        }
        return $this->response = new Response($this, $xmlResponse);
    }

}

