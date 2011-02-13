<?php

class Queroeventos_Layout extends Zend_Controller_Plugin_Abstract
{

    public function  dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        parent::dispatchLoopStartup($request);

        $layout = Zend_Layout::startMvc();

        /**
         * pega o nome do módulo em que está trabalhando e define o caminho do mesmo
         */
        $layout->setLayout($request->getModuleName())
               ->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/layouts/scripts');
    }

}