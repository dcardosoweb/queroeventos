<?php

class FewprivilagesController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_helper->_acl->allow(null);
    }

    public function indexAction()
    {
        $this->view->mensagem = 'Vc nao tem privilegio para usar este recurso...';
    }
}