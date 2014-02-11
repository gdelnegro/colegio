<?php

class Admin_AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        return $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        $this->_flashMessenger = $this->_helper->getHelper("FlashMessenger");
        $this->view->messages = $this->_flashMessenger->getMessages();
        
        $form = new Admin_Form_Login();
        #$dados = $this->getRequest()->getPost();
        #$this->view->dados = $dados;
        
        if( $this->getRequest()->isPost() ){
            $data = $this->getRequest()->getPost();
            
            if( $form->isValid($data) ){
                
                $login = $form->getValue('login');
                $senha = $form->getValue('senha');
                
                try {
                    
                    Admin_Model_Auth::login($login, $senha);
                    
                    return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'usuario'),null,true);
                    
                } catch (Exception $exc) {
                    $this->_helper->FlashMessenger($exc->getMessage());
                    $this->_redirect('admin/auth/login');
                }
            }else{
                $form->populate($data);
            }
        }
        $this->view->dados = $data;
        $this->view->form = $form;
    }
    
    public function logoutAction(){
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector('index');
    }


}



