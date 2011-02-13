<?php

class Default_NotallowedController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_helper->_acl->allow(null);
    }

    public function indexAction()
    {
        $this->view->mensagem = 'Voce nao esta autorizado a utilizar este recurso...';
    }
}