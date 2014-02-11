<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function __initAcl(){
        $aclSetup = new Opi_Acl_Setup();
    }
}