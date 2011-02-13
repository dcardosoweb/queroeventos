<?php

class Queroeventos_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Abstract
{

    protected $_action;


    protected $_auth;


    protected $_acl;


    protected $_controllerName;

   
    public function __construct(Zend_View_Interface $view = null, array $options = array())
    {
        $this->_auth = Zend_Auth::getInstance();
        $this->_acl = $options['acl'];
    }


    public function init()
    {
        $this->_action = $this->getActionController();

        $controller = $this->_action->getRequest()->getControllerName();
        $this->_controllerName = $controller;
        if(!$this->_acl->has($controller)) {
            $this->_acl->add(new Zend_Acl_Resource($controller));
        }

    }

    
    public function preDispatch()
    {
        $role = 'guest';
        if ($this->_auth->hasIdentity()) {
            $user = $this->_auth->getIdentity();
            if(is_object($user)) {
                $role = $this->_auth->getIdentity()->role;
            }
        }

        $request = $this->_action->getRequest();
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $module = $request->getModuleName();

        $resource = $controller;
        $privilege = $action;

        if (!$this->_acl->has($resource)) {
            $resource = null;
        }

        if (!$this->_acl->isAllowed($role, $resource, $privilege)) {
            if (!$this->_auth->hasIdentity()) {
                $noPermsAction = $this->_acl->getNoAuthAction();
            } else {
                $noPermsAction = $this->_acl->getNoAclAction();
            }

            $request->setModuleName($noPermsAction['module']);
            $request->setControllerName($noPermsAction['controller']);
            $request->setActionName($noPermsAction['action']);
            $request->setDispatched(false);
        }
    }

   
    public function allow($roles = null, $actions = null)
    {
        $resource = $this->_controllerName;
        $this->_acl->allow($roles, $resource, $actions);
        return $this;
    }


    public function deny($roles = null, $actions = null)
    {
        $resource = $this->_controllerName;
        $this->_acl->deny($roles, $resource, $actions);
        return $this;
    }

}
