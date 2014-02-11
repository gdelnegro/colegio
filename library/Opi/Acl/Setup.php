<?php 
class Opi_Acl_Setup { 
    /** * @var Zend_Acl */ protected $_acl; 
    
    public function __construct() { 
        $this->_acl = new Zend_Acl(); 
        $this->_initialize(); 
        
    } 
    
    protected function _initialize() { 
        $this->_setupRoles(); 
        $this->_setupResources(); 
        $this->_setupPrivileges(); 
        $this->_saveAcl(); 
        
    } 
    
    protected function _setupRoles() { 
        $this->_acl->addRole( new Zend_Acl_Role('guest') ); 
        $this->_acl->addRole( new Zend_Acl_Role('professor'), 'guest' ); 
        $this->_acl->addRole( new Zend_Acl_Role('administrador'), 'professor' ); 
        
    } 
    
    protected function _setupResources() { 
        $this->_acl->addResource( new Zend_Acl_Resource('auth') ); 
        $this->_acl->addResource( new Zend_Acl_Resource('usuarios') ); 
    } 
    
    protected function _setupPrivileges() { 
        $this->_acl->allow( 'guest', 'auth', array('index', 'login') ) 
                ->allow( 'guest', 'error', array('error', 'forbidden') ); 
        $this->_acl->allow( 'professor', 'usuarios', array('index') ) 
                ->allow( 'professor', 'auth', 'logout' ); 
        $this->_acl->allow( 'administrador', 'usuarios', array('index', 'adicionar') ); 
        
    } 
    
    protected function _saveAcl() { 
        $registry = Zend_Registry::getInstance(); 
        $registry->set('acl', $this->_acl); 
        
    } 
    
}