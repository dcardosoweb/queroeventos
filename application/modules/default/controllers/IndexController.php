<?php

class Default_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $this->_helper->_acl->allow(null);
    }

    
    public function indexAction()
    {
        // action body
    }


}

