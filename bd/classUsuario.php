<?php

class Usuario{
    private $id;
	private $nome;
    private $sobrenome;
	private $sexo;
	private $ddd;
	private $celular;
	private $email;
	private $dt_nascimento;
	private $endereco;
	private $cidade;
	private $estado;
    private $apelido;
	private $time;
	private $posicao;
	private $pontuacao;
	private $senha;
    private $foto_perfil;
	private $tipo_usuario;
	
	
    public $conexao;
	
    private $select_usuario; // SELECT QUADRA
    private $dados_usuario; // DADOS QUADRA
	
	private $select_time; // SELECT TIME
    private $dados_time; // DADOS TIME
	
	private $select_posicao; // SELECT POSICAO
    private $dados_posicao;	// DADOS POSICAO
    
    public function __construct($i='', $nom='', $sob='', $sex='', $ddd='', $cel='', $ema='', $dtn='', $end='', $cid='', $est='', $ape='', $tim='', $pos='', $pon='', $sen='', $fot='', $tip=''){
       $this->conexao = new mysqli("localhost","root","","soubo734_bd2");
       
        $this->id = $i;
		$this->nome = $nom;
        $this->sobrenome = $sob;
        $this->sexo = $sex;
		$this->ddd = $ddd;
		$this->celular = $cel;
		$this->email = $ema;
		$this->dt_nascimento = $dtn;
		$this->endereco = $end;
        $this->cidade = $cid;
		$this->estado = $est;
		$this->apelido = $ape;
		$this->time_esp = $tim;
		$this->posicao = $pos;
		$this->pontuacao = $pon;
		$this->senha = $sen;
		$this->foto_perfil = $fot;
		$this->tipo_usuario = $tip;
    }	
    
     public function inserir(){
        $sql = "insert into usuario(nome, sobrenome, sexo, ddd, celular, email, dt_nascimento, id_cidade, id_estado, senha, TIPO_USUARIO) "
                ."values('$this->nome','$this->sobrenome','$this->sexo','$this->ddd','$this->celular','$this->email','$this->dt_nascimento','$this->cidade','$this->estado', '$this->senha', '$this->tipo_usuario')";
        $resultado = $this->conexao->query($sql);
        return $resultado;
		
    }
	
	public function VerificaEmail($email){
        $sql = "select * from usuario where email = '$email'";
        $resultado = $this->conexao->query($sql);
		if($resultado->num_rows > 0){
			return true;
		}
		else{
			return false;
		}
        
    }
	
	public function alterar($nome, $sobrenome, $sexo, $ddd, $celular, $email, $dt_nascimento, $endereco, $cidade, $estado, $apelido, $time, $posicao, $id){
        $sql = "update usuario set nome = '$nome', sobrenome = '$sobrenome', sexo = '$sexo', ddd = '$ddd', celular = '$celular', email = '$email',".
		" dt_nascimento = '$dt_nascimento', endereco = '$endereco', id_cidade = '$cidade', id_estado = '$estado', apelido = '$apelido', id_time = '$time',".
		" id_posicao = '$posicao' where id = $id";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }
	
	/*public function excluir($id){
        $sql = "delete from usuarios where id = $id";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }*/
    
    
	
	public function selectUsuario($id){
        $sql = "SELECT * FROM usuario where id = $id";
        $this->select_usuario = $this->conexao->query($sql);
        return $this->select_usuario;
    }
    
    public function dadosUsuario(){
        $this->dados_usuario = $this->select_usuario->fetch_array(MYSQLI_ASSOC);
        return $this->dados_usuario;
    }
	
	public function selectTime(){
        $sql = "SELECT * FROM time_esp";
        $this->select_time = $this->conexao->query($sql);
        return $this->select_time;
    }
    
    public function dadosTime(){
        $this->dados_time = $this->select_time->fetch_array(MYSQLI_ASSOC);
        return $this->dados_time;
    }
	
	public function selectPosicao(){
        $sql = "SELECT * FROM posicao";
        $this->select_posicao = $this->conexao->query($sql);
        return $this->select_posicao;
    }
    
	
    public function dadosPosicao(){
        $this->dados_posicao = $this->select_posicao->fetch_array(MYSQLI_ASSOC);
        return $this->dados_posicao;
    }

	/*
    public function __destruct() {
        $this->conexao->close();
    }
	*/
	
	public function logar($login, $senha){
        $sql = "select * from usuario where (email = '$login' or apelido ='$login') and senha = '$senha'";
        $resultado = $this->conexao->query($sql);
        if($resultado->num_rows == 1){
            $dados = $resultado->fetch_array(MYSQLI_ASSOC);
            return $dados;
        }
        else{
            return FALSE;
        }
    }
	
}
?>