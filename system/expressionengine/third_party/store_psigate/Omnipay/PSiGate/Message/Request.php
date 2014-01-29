<?php

namespace Omnipay\PSiGate\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * PSiGate  Request
 */
class Request extends AbstractRequest
{
    public function getEndpoint()
    {
	    return ($this->getMode() == 'test') ? 
	    	'https://devcheckout.psigate.com/HTMLPost/HTMLMessenger' : 
	    	'https://checkout.psigate.com/HTMLPost/HTMLMessenger';
    }  
    
    public function getKey()
    {
        if($this->getMode() == 'test')
        {
	        return 'merchantcardcapture200024';
        }
        else
        {
        	return $this->getStoreKey();
        }
    }

    public function send()
    {
        return $this->sendData($this->getData());
    }
    
	public function sendData($data){
	    
	    $httpRequest = $this->httpClient->createRequest(
            'POST',
            $this->getEndpoint(),
            null,
            $data
        );
        
        $httpResponse = $httpRequest->send();
        return $this->response = new Response($this, $httpResponse->getBody());
    }

    public function getData()
    {
        $this->getCard()->validate();

        $data = array(
			'MerchantID' => $this->getKey(),
			'PaymentType' => 'CC',
			'CardAction' => 0,
			'ResponseFormat' => 'XML',
			'CustomerIP' => $this->getClientIp(),
			'Bname' => $this->getCard()->getBillingName(),
			'Bcompany' => $this->getCard()->getBillingCompany(),
			'Baddress1' => $this->getCard()->getBillingAddress1(),
			'Baddress2' => $this->getCard()->getBillingAddress2(),
			'Bcity' => $this->getCard()->getBillingCity(),
			'Bprovince' => $this->getCard()->getState(),
			'Bpostalcode' => $this->getCard()->getPostcode(),
			'Bcountry' => $this->getCard()->getCountry(),
			'Sname' => $this->getCard()->getShippingName(),
			'Scompany' => $this->getCard()->getShippingCompany(),
			'Saddress1' => $this->getCard()->getShippingAddress1(),
			'Saddress2' => $this->getCard()->getShippingAddress2(),
			'Scity' => $this->getCard()->getShippingCity(),
			'Sprovince' => $this->getCard()->getState(),
			'Spostalcode' => $this->getCard()->getPostcode(),
			'Scountry' => $this->getCard()->getCountry(),
			'Phone' => $this->getCard()->getPhone(),
			'Email' => $this->getCard()->getEmail(),
			'FullTotal' => $this->getAmount(),
			'CardNumber' => $this->getCard()->getNumber(),
			'CardExpMonth' => str_pad($this->getCard()->getExpiryMonth(), 2, '0', STR_PAD_LEFT),
			'CardExpYear' => substr($this->getCard()->getExpiryYear(), 2, 2),
			'CardIDNumber' => $this->getCard()->getCvv() 
		);
        
         if($this->getMode() == 'test')
		{
			$data['TestResult'] = $this->getTestModeResponse();
		}
		
        return $data;
    }  
    
	public function getMode()
    {
        return $this->getParameter('mode');
    }

    public function setMode($value)
    {
        return $this->setParameter('mode', $value);
    }
    
	public function getTestModeResponse()
    {
        return $this->getParameter('testModeResponse');
    }

	public function setTestModeResponse($value)
    {
        return $this->setParameter('testModeResponse', $value);
    }
    
	public function getStoreKey()
    {
        return $this->getParameter('storeKey');
    }

	public function setStoreKey($value)
    {
        return $this->setParameter('storeKey', $value);
    }
}
