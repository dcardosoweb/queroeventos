<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload()
    {

        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
        ));

        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Queroeventos');

        return $autoloader;

    }


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

    
    protected function _initPluginLayout()
    {
        $bootstrap = $this->getApplication();

        /**
         * Se minha aplicação está sendo extendido da Zend_Application,
         * $bootstrap recebe $this.
         */
        if($bootstrap instanceof Zend_Application)
        {
            $bootstrap = $this;
        }

        /**
         * Recupera FrontController para manipulá-lo
         */
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        /**
         * Registra o plugin no FrontController, para mudar os módulos
         */
        $plugin_layout = new Queroeventos_Layout();

        $front->registerPlugin($plugin_layout);
    }


    protected function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('Queroeventos_Controller_Action_Helper_');

        $acl = new Queroeventos_Acl();
        $aclHelper = new Bndes_Controller_Action_Helper_Acl(null, array('acl' => $acl));
        Zend_Controller_Action_HelperBroker::addHelper($aclHelper);
    }

    protected function _initDocType()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }

    protected function _initZendAuth()
    {

        /**
         * TODO: Criar as regras de Auth/ACL...
         */

    }
}

