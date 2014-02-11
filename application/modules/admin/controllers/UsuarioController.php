<?php

class Admin_UsuarioController extends Zend_Controller_Action
{

    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'Auth'),null,true);
        }
    }

    public function indexAction()
    {
        $usuario = new Admin_Model_Usuario('usuarios','idUsuario');
        $dadosUsuario = $usuario->procurar();
        
        $paginator = Zend_Paginator::factory($dadosUsuario);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function editAction(){
        
        $auth = Zend_Auth::getInstance();
        $user = $auth->getIdentity();
        $usr = ($user->idUsuario); //Id do usuário logado
        
        $usuario = new Admin_Model_Usuario('usuarios', 'idUsuario');
        $dadosUsuario = $usuario->procurar($this->_getParam('id'));
        
        $formUsuario = new Admin_Form_Usuario('edit');
        
        $this->view->formulario = $formUsuario->populate($dadosUsuario);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            
            if ( $formUsuario->isValid($data) ){
                $this->view->dados = $data;
                #$usuario->alterar($data);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'usuario'), null, true);
            }
        }
        
    }


}

