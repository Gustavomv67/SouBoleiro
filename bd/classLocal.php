<?php


class Local{
	
    public $conexao;
	
    private $select_cidade; // SELECT CIDADE
    private $dados_cidade; // DADOS CIDADE
	
	private $select_estado; // SELECT ESTADO
    private $dados_estado; // DADOS ESTADO
	
    
    public function __construct(){
        $this->conexao = new mysqli('localhost', 'root', '', 'soubo734_bd2');
    }	
    
	public function selectCidade(){
        $sql = "SELECT * FROM cidade";
        $this->select_cidade = $this->conexao->query($sql);
        return $this->select_cidade;
    }
    
    public function dadosCidade(){
        $this->dados_cidade = $this->select_cidade->fetch_array(MYSQLI_ASSOC);
        return $this->dados_cidade;
    }
	
	public function selectEstado(){
        $sql = "SELECT * FROM estado";
        $this->select_estado = $this->conexao->query($sql);
        return $this->select_estado;
    }
    
    public function dadosEstado(){
        $this->dados_estado = $this->select_estado->fetch_array(MYSQLI_ASSOC);
        return $this->dados_estado;
    }
	
	
}
?>