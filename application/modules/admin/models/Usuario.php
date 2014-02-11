<?php

/**
 * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
 * @version v0.1
 */
class Admin_Model_Usuario
{
    
    public $nome;
    protected $_login;
    private $_senha;
    public $email;
    protected $_grupo;
    protected $_tabela;
    protected $_chave;
    public $banco;
    
    /**
     * 
     * @param type $tabela tabela do usuário
     * @param type $chave chave primária da tabela
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function __construct($tabela, $chave) {
        
        $this->_tabela = $tabela;
        
        $this->_chave = $chave;
        
    }
    
    /**
     * 
     * @param type $propriedade propriedade que será editada
     * @param type $valor valor que será atribuido à propriedade
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function __set($propriedade, $valor) {
        try {
            
            $this->$propriedade = $valor;
            
        } catch (Exception $exc) {
            
            echo $exc->getTraceAsString();
            
        }

    }
    
    public function __get($propriedade){
        if (property_exists($this, $propriedade)){
            
            return $this->$propriedade;
            
        }else{
            
            return 'Propriedade inexistente';
            
        }
        
    }
    public function procurar($id = null, $where = null, $order = null, $limit = null){
        $banco = new Opi_Db_DB($this->_tabela, $this->_chave);
        return $banco->pesquisar($id, $where, $order, $limit);
    }
    /**
     * 
     * @param array $dados array com os dados vindos de quem chamar o método
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @return boolean
     * @since v0.1
     */
    public function criar(array $dados){
        
        if(!is_null($dados)){
            
            $dadosUsuario = array(
                'nomeColuna' => $dados['nomePropriedade']
            );
            
            return $this->_banco->incluir($dadosUsuario);
        }else{
            return false;
        }
        
    }
    
    
    /**
     * 
     * @param array $dados dados vindos de quem chamar o método
     * @return boolean
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function alterar( array $dados){
        
        if(!is_null( $dados )){
            
            $dadosUsuario = array(
                'nomeColuna' => $dados['nomePropriedade']
            );
            
            $where = ("NOMECOLUNA = ?".$VALOR); 
            
            return $this->_banco->atualizar($dadosUsuario, $where);
            
        }else{
            return false;
        }
        
    }
    
    /**
     * 
     * @param array $dados formato MODELO: array('key'=>'idMateria','value'=>'titulo');
     * @return type
     */
    public function listar(array $dados){
        
        if (!is_null($dados)){
            
            return $this->_banco->listar($dados);
            
        }else{
            
            return false;
            
        }

    }
    
}