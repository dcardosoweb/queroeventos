<?php
class Queroeventos_Acl extends Zend_Acl
{

    private $_noAuth;
    private $_noAcl;

    public function  __construct()
    {
        $config = Zend_Registry::get('config');
        $roles = $config->acl->roles;
        $this->_addRoles($roles);
        $this->_loadRedirectActions($config->acl);
    }

    public function setNoAuthAction($noAuth)
    {
        $this->_noAuth = $noAuth;
    }

    public function setNoAclAction($noAcl)
    {
        $this->_noAcl = $noAcl;
    }
    public function getNoAuthAction()
    {
        return $this->_noAuth;
    }

    public function getNoAclAction()
    {
        return $this->_noAcl;
    }

    protected function _addRoles($roles)
    {

        foreach($roles as $name=>$parents)
        {
            if(!$this->hasRole($name))
            {
                if(empty ($parents))
                {
                    $parents = null;
                }
                else
                {
                    $parents = explode(',', $parents);
                }
                $this->addRole(new Zend_Acl_Role($name), $parents);
            }
        }

    }

    public function _loadRedirectActions($aclConfig)
    {

        $this->_noAuth = array(
            'module'     => 'default',
            'controller' => 'fewprivilages',
            'action'     => 'index'
        );

        $this->_noAcl = array(
            'module'     => 'default',
            'controller' => 'notallowed',
            'action'     => 'index'
        );

    }

}
