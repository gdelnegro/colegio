<?php

class Opi_Db_DB extends Zend_Db_Table_Abstract
{

    protected $_name;
    protected $_primary;
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param type $nome nome da tabela
     * @param type $pk chave primária
     * @param type $config
     * @since v0.1
     */
    public function __construct($nome, $pk,$config = array()) {
        $this->_name = $nome;
        $this->_primary = $pk;
        parent::__construct($config);
    }
    
    /**
     * 
     * @param type $propriedade
     * @return type
     * @since v0.1
     */
    public function __get( $propriedade ){
        return $this->$propriedade;
    }
    
    /**
     * 
     * @param type $propriedade
     * @param type $valor
     * @since v0.1
     */
    public function __set($propriedade, $valor) {
        $this->$propriedade = $valor;
    }
    
    /**
     * 
     * @param int $id Id do registro que será pesquisado
     * @param string $where clásula where da pesquisa
     * @param string $order ordenação dos resultados
     * @param int $limit limite de resultados retornados
     * @return array, array com os valores retornados
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function pesquisar($id = null, $where = null, $order = null, $limit = null){
        
        if( !is_null($id) ){
            
            $arr = $this->find($id)->toArray();
            
            return $arr[0];
            
        }else{
            
            $select = $this->select()->from($this)->order($order)->limit($limit);
            
            if(!is_null($where)){
                
                $select->where($where);
                
            }
            
            return $this->fetchAll($select)->toArray();
        }
    }
    
    /**
     * 
     * @param array $dados Array com os dados a serem inseridos no banco MODELO: 'nome_campo' => 'valor'
     * @return boolean 
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @version 0.1
     * @since v0.1
     */
    public function incluir(array $dados){
        
        if ( !is_null( $dados ) ){
            
            try {
                
                $this->insert($dados);
                
            } catch (Zend_Db_Exception $exc) {
                
                return $exc->getMessage();
            }
            
        }else{
            
            return false;
            
        }

    }
    
    /**
     * 
     * @param array $dados Array com os dados a serem inseridos no banco MODELO: 'nome_campo' => 'valor'
     * @param string $where String com a clásula where MODELO: $where = $this->getAdapter()->quoteInto("NOMECOLUNA = ?", $VALOR);
     * @return boolean
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function atualizar(array $dados,$where){
        if ( !is_null( $dados ) OR !is_null( $where ) ){
            
            try {
                 
                $this->update($dados, $where);
                
            } catch (Zend_Db_Exception $exc) {
                
                return $exc->getMessage();
                
            }
        }else{
            
            return false;
            
        }
    }
    
    /**
     * 
     * @param array $dados, contendo a coluna de id da tabela, e a coluna que deseja retornar. MODELO: array('key'=>'idMateria','value'=>'titulo');
     * @return boolean
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @since v0.1
     */
    public function listar(array $dados){
        
        if ( !is_null($dados) ){
            $select = $this->_db->select()
                ->from($this->_name, $dados);
        
            try{
            
                $result = $this->getAdapter()->fetchAll($select);
            
            } catch ( Zend_Db_Exception $exc ) {
            
                return $exc->getMessage();
            
            }
        
        return $result;
        }else{
            
            return false;
            
        }
        
    }


}