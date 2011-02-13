<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initConfig()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'development');
        Zend_Registry::set('config', $config);
    }

    
    protected function _initRequest(array $options = array ())
    {

         // Ensure front controller instance is present, and fetch it
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');

        // Initialize the request object
        $request = new Zend_Controller_Request_Http();
        $request->setBaseUrl(dirname($_SERVER['SCRIPT_NAME']));

        // Add it to the front controller
        $front->setRequest($request);

        //$front->addControllerDirectory(APPLICATION_PATH . '/modules/forum/controllers', 'forum');

        // Bootstrap will store this value in the 'request' key of its container
        return $request;

    }

}

