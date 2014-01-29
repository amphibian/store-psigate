<?php

namespace Omnipay\PSiGate;

use Omnipay\Common\AbstractGateway;
use Omnipay\Beanstream\Message\Request;

/**
 * PSiGate Gateway
 *
 * @link http://www.psigate.com/pages/techsupport.asp?lang=EN&s=5&p1=68
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'PSiGate';
    }

    public function getDefaultParameters()
    {
        return array(
            'storeKey' => '',
            'mode' => array('test', 'production'),
            'testModeResponse' => array('R', 'A', 'D', 'F')
        );
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\PSiGate\Message\Request', $parameters);
    }

}
