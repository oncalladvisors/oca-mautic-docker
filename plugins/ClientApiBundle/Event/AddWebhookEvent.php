<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/3/15
 * Time: 4:23 PM
 */

namespace MauticAddon\ClientApiBundle\Event;

use Mautic\CoreBundle\Event\CommonEvent;
use Mautic\LeadBundle\Entity\Lead;

class AddWebhookEvent extends CommonEvent
{
    protected  $clientApiId;
    protected  $methodUrl;
    protected  $headerParameters;
    protected  $requestType;
    protected  $parameters;
    protected  $jsonData;

    public function __construct(Lead &$lead, $clientApiId, $methodUrl, $headerParameters, $requestType, $parameters, $jsonData)
    {
        $this->entity =& $lead;
        $this->clientApiId = (int)$clientApiId;
        $this->methodUrl = $methodUrl;
        $this->headerParameters = $headerParameters;
        $this->requestType =  $requestType;
        $this->parameters  = $parameters;
        $this->jsonData = $jsonData;
    }


    public function getLead()
    {
        return $this->entity;
    }

    public function getClientApiId()
    {
        return $this->clientApiId;
    }

    public function getMethodUrl()
    {
        return $this->methodUrl;
    }

    public function getHeaderParameters()
    {
        return $this->headerParameters;
    }

    public function getRequestType()
    {
        return $this->requestType;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getJsonData()
    {
        return $this->jsonData;
    }

}