<?php
/**
 * Created by PhpStorm.
 * User: wordpress
 * Date: 9/2/15
 * Time: 4:22 PM
 */

namespace MauticAddon\ClientApiBundle\Helper;
use Mautic\CoreBundle\Factory\MauticFactory;
use Mautic\LeadBundle\Entity\Lead;
use GuzzleHttp\Client;
use MauticAddon\ClientApiBundle\Entity\RequestActionLog;

class CampaignEventHelper
{

    public static function makeRequest($event, Lead $lead, MauticFactory $factory){

        $clientApiId = $event['properties']['clientApi'];

        //Get client Api entity
        $clientApiModel = $factory->getModel('addon.clientApi.clientApi');
        $clientApi = $clientApiModel->getEntity($clientApiId);

        $methodUrl =  $event['properties']['apiMethod'];
        //$methodUrl = urlencode($methodUrl);
        $fullUrl = $clientApi->getBaseUrl();


        $requestMethod = $event['properties']['requestMethod'];

        $headerParameters = [];
        if(isset($event['properties']['headerParameters'])){
            $headerParameters = $event['properties']['headerParameters'];
        }

        $requestType = $event['properties']['requestType'];
        $isFormData = false;
        if($requestType === 'form-data')
            $isFormData = true;

        //Get json information
        $jsonContent = "";
        if(isset($event['properties']['jsonData'])){
            $jsonContent = $event['properties']['jsonData'];
        }

        //General vars
        $headers = [];
        //$fullUrl = urlencode($fullUrl);
        $queryArray = [];
        $bodyParams = [];
        $body = [];

        /**
         * Build headers
         */
        $headerParameter = $clientApi->getHeaderParameter();

        if(!empty($headerParameter)){

            $parts = explode("=", $headerParameter);
            $headers[$parts[0]] = $parts[1];
        }

        $headerParamNames = $headerParameters['paramName'];
        $headerParamValues = $headerParameters['paramValue'];
        if(!empty($headerParamNames) && $headerParamNames[0] != null){

            foreach($headerParamNames as $index => $name){
                $headers[$name] = $headerParamValues[$index];
            }
        }

        /**
         * Build body or query string parameters
         */
        $parameters = $event['properties']['parameters'];
        $paramNames = $parameters['paramName'];
        $paramVals = $parameters['paramValue'];

        $options = [];

        if($requestType=="GET"){
            if(!empty($paramNames) && $paramNames[0] != null)
            {
                foreach($paramNames as $paramIndex => $paramName)
                {
                    dump($paramVals[$paramIndex]);
                    //Parse lead fields
                    if(preg_match('/^{{*$}}/',$paramVals[$paramIndex])){
                        $leadFieldName = substr($paramVals[$paramIndex], 2, -2);
                        $leadFields = $lead->getFields();

                        if(isset($leadFields['core'][$leadFieldName])){
                            dump("Field found " . $leadFieldName);
                            $queryArray[$paramName] = $leadFields['core'][$leadFieldName]['value'];
                        } else {
                            dump("Field not found " . $leadFieldName);
                            $queryArray[$paramName] = $paramVals[$paramIndex];
                        }
                    }
                    $queryArray[$paramName] = $paramVals[$paramIndex];
                }
            }
        } else {

            if(!empty($paramNames) && $paramNames[0] != null)
                foreach($paramNames as $paramIndex => $paramName){

                    dump($paramVals[$paramIndex]);
                    //Parse lead fields
                    if(preg_match('#^{{.*}}$#', $paramVals[$paramIndex])){

                        $leadFieldName = substr($paramVals[$paramIndex], 2, -2);
                        $leadFields = $lead->getFields();

                        if(isset($leadFields['core'][$leadFieldName])){
                            dump("Field found " . $leadFieldName);
                            $queryArray[$paramName] = $leadFields['core'][$leadFieldName]['value'];
                        } else {
                            dump("Field not found " . $leadFieldName);
                            $queryArray[$paramName] = $paramVals[$paramIndex];
                        }
                    }

                    $bodyParams[$paramName] = $paramVals[$paramIndex];
                }

            if($isFormData){
                $body = $bodyParams;
                $options = ['form_params' => $body];
            } else {
                $body = $jsonContent;
                $options = ['body' => $body];
            }
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $fullUrl,
            // You can set any number of default request options.
            'timeout'  => 2.0,
            //headers
            'headers' => $headers
        ]);



        $reqActionLogModel  = $factory->getModel('addon.ClientApi.RequestActionLog');

        switch($requestMethod){
            case 'POST':
                $promise = $client->postAsync($methodUrl, $options)->then(function ($response) use ($reqActionLogModel) {

                    $requestActionLog = new RequestActionLog();
                    $requestActionLog->setResponseCode($response->getStatusCode());
                    $requestActionLog->setResponseBody($response->getBody());
                    $reqActionLogModel->saveEntity($requestActionLog);
                });
                $promise->wait();
                break;
            case 'GET':
                $promise = $client->getAsync($methodUrl,['query' => $queryArray])->then(function ($response) use ($reqActionLogModel) {
                    $requestActionLog = new RequestActionLog();
                    $requestActionLog->setResponseCode($response->getStatusCode());
                    $requestActionLog->setResponseBody($response->getBody());
                    $reqActionLogModel->saveEntity($requestActionLog);
                });
                $promise->wait();
                break;
            case 'PUT':
                $promise = $client->putAsync($methodUrl, $options)->then(function ($response) use ($reqActionLogModel) {
                    $requestActionLog = new RequestActionLog();
                    $requestActionLog->setResponseCode($response->getStatusCode());
                    $requestActionLog->setResponseBody($response->getBody());
                    $reqActionLogModel->saveEntity($requestActionLog);
                });
                $promise->wait();
                break;
            case 'DELETE':
                $promise = $client->deleteAsync($methodUrl, $options)->then(function ($response) use ($reqActionLogModel) {
                    $requestActionLog = new RequestActionLog();
                    $requestActionLog->setResponseCode($response->getStatusCode());
                    $requestActionLog->setResponseBody($response->getBody());
                    $reqActionLogModel->saveEntity($requestActionLog);
                });
                $promise->wait();
                break;
            default:
                break;
        }
    }
}
