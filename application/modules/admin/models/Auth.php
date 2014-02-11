<?php

class Admin_Model_Auth
{
    public static function login($login, $senha){
        
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setTableName('usuarios')
                ->setIdentityColumn('login')
                ->setCredentialColumn('senha')
                ->setCredentialTreatment('MD5(?)');
        
        $authAdapter->setIdentity($login)
                ->setCredential($senha);
        
        $select = $authAdapter->getDbSelect();
        
        #$select->join( array('p' => 'perfil'), 
                #'p.idPerfil = usuarios.perfil', 
                #array('nomePerfil' => 'nomePerfil'));
        
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        
        if($result->isValid()){
            $info = $authAdapter->getResultRowObject(null,'senha');
            $usuario = new Admin_Model_Usuario();
            
            $usuario->__set('nome',$info->nome);
            $usuario->__set('login',$info->login);
            $usuario->__set('_roleId',$info->nomePerfil);
            $storage = $auth->getStorage();
            $storage->write($usuario);
            return true;
        }
        
        throw new Exception('Nome de usuário ou senha inválidos');
    }
}

