<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'Auth'),null,true);
        }
    }

    public function indexAction()
    {
    }


}

