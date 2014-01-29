<?php

namespace Omnipay\PSiGate\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * PSiGate Response
 */
class Response extends AbstractResponse
{
    public function isSuccessful()
    {
        $data = $this->data_array();
        // print_r($data); exit();
        return ($data->Approved == 'Approved' || substr($data->ReturnCode, 0, 1) == 'Y');
    }

    public function getTransactionReference()
    {
        $data = $this->data_array();
        return $data->OrderID;
    }

    public function getMessage()
    {
        if(!$this->isSuccessful())
        {
	        $data = $this->data_array();
        	$message = $data->Approved;
        	if(!empty($data->ErrMsg))
        	{
        		$message .= ': '.$data->ErrMsg;
        	}
        	return (string) $message;
        }
    }
    
    public function data_array()
    {
    	return simplexml_load_string($this->data);
    }
}
