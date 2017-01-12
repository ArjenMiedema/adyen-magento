<?php

namespace Adyen\Service;

class Resource
{

    protected $_service;
    protected $_endpoint;
    protected $_requiredFields;

    public function __construct(\Adyen\Service $service, $endpoint, $requiredFields)
    {
        $this->_service = $service;
        $this->_endpoint = $endpoint;
        $this->_requiredFields = $requiredFields;
    }

    /**
     * Do the request to the Http Client
     *
     * @param $params
     * @return mixed
     */
    public function request($params)
    {
        // convert to PHP Array if type is inputType is json
        if($this->_service->getClient()->getConfig()->getInputType() == 'json')
        {
            $params = json_decode($params);
        }

        // validate the request parameters
        $this->_validate($params);

        $curlClient = $this->_service->getClient()->getHttpClient();
        return $curlClient->requestJson($this->_service, $this->_endpoint, $params);
    }

    public function requestPost($params)
    {
        // validate the request parameters
        $this->_validate($params);

        $curlClient = $this->_service->getClient()->getHttpClient();
        return $curlClient->requestPost($this->_service, $this->_endpoint, $params);
    }


    /**
     * Validate if all required fields are in the params
     *
     * @param $params
     */
    protected function _validate($params)
    {
        if(is_array($this->_requiredFields)) {
            foreach($this->_requiredFields as $requiredField) {

                if (  strpos ($requiredField,"." ) !== FALSE ){

                    // split on .
                    // check if this array part exisst in provided array can be done with isset(['param1']['param2']

                    // ignore for now
                    continue;
                }

                if(!array_key_exists($requiredField, $params)) {
                    // TODO: throw error
                    echo 'missing field ' . $requiredField;
                }
//                $this->_valdiateFields($requiredField, $type, $params);
            }
        }

    }

    protected function _valdiateFields($requiredField, $type, $params)
    {

        echo 'hier' . $requiredField;
        if(is_string($requiredField)) {

        }

        if(is_array($type)) {
            // todo: validate in array

        }
    }


    protected function array_keys_recursive($myArray, $arrayKeys = array())
    {
        $keys = array_keys($myArray);

        foreach($keys as $key){
            if(is_array($myArray[$key])){
                $arrayKeys[$key] = $this->array_keys_recursive($myArray[$key]);
            }
        }

        return $arrayKeys;
    }

}