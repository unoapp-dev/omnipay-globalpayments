<?php

namespace Omnipay\GlobalPayments\Message;

use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function isSuccessful()
    {
       if( !empty($this->data->result) &&  $this->data->result == '00')
        return 1;
        else
        return 0;
    }

    public function getMessage()
    {
        return (string) $this->data->message;
    }

    public function getTransactionReference()
    {
        return empty($this->data->pasref) ? null : (string) $this->data->pasref;
    }

    public function getCardReference()
    {
        if (! empty($this->data->pasref)) {
            return (string) $this->data->pasref;
        }
        return null;
    }

    public function getCode()
    {
        return null;
    }
    public function getAuthCode()
    {
        return empty($this->data->authcode) ? null : (string) $this->data->authcode;
    }

    public function getOrderNumber()
    {
        return null;
    }

    public function getData()
    {
        return preg_replace('/\n/', '', ($this->data)->asXML());
    }
}

