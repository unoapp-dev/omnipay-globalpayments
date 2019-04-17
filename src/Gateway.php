<?php

namespace Omnipay\GlobalPayments;

use Omnipay\Common\AbstractGateway;

/**
 * PaymentExpress Gateway
 * @link https://developer.realexpayments.com/#!/
 */

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'GlobalPayments';
    }

    public function getDefaultParameters()
    {
        return [
            'merchantid' => '',
            'account' => '',
            'channel' => '',
            'sharedSecret' => '',
            'rebatePassword' => '',
        ];
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

    public function getMerchantCurrency()
    {
        return $this->getParameter('merchantCurrency');
    }
    public function setMerchantCurrency($value)
    {
        return $this->setParameter('merchantCurrency', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function createProfile(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\CreateProfileRequest', $parameters);
    }

    public function validateCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\ValidateCardRequest', $parameters);
    }

    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\CreateCardRequest', $parameters);
    }

    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\DeleteCardRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\AuthorizeRequest', $parameters);
    }

    public function capture(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\CaptureRequest', $parameters);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\PurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\GlobalPayments\Message\RefundRequest', $parameters);
    }
}

