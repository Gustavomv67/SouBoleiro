<?php

class Quadra{
    private $id;
	private $nome;
    private $logradouro;
    private $numero;
    private $bairro;
	private $cidade;
    private $estado;
	private $cep;
	private $lat;
	private $lng;
	private $dono;
	
    public $conexao;
	
    private $select_quadra; // SELECT QUADRA
    private $dados_quadra; // DADOS QUADRA
	
	private $select_minhaquadra; // SELECT MINHA QUADRA
    private $dados_minhaquadra; // DADOS MINHA QUADRA
	
	private $select_fotos; // SELECT FOTOS
    private $dados_fotos; // DADOS FOTOS
	
	private $select_servicos; // SELECT SERVICOS
    private $dados_servicos; // DADOS SERVICOS
	
	private $select_horarios; // SELECT HORARIOS
    private $dados_horarios; // DADOS HORARIOS
	
	private $select_reserva; // SELECT RESERVA
    private $dados_reserva; // DADOS RESERVA
    
    public function __construct($i='', $nom='', $log='', $num='', $bai='', $cid='', $est='', $cep='', $lat='', $lng='', $don=''){
        $this->conexao = new mysqli("localhost","root","","soubo734_bd2");
       
        $this->id = $i;
		$this->nome = $nom;
        $this->logradouro = $log;
        $this->numero = $num;
		$this->bairro = $bai;
		$this->cidade = $cid;
		$this->estado = $est;
		$this->cep = $cep;
        $this->lat = $lat;
		$this->lng = $lng;
		$this->dono = $don;
    }	
    
     public function inserir(){
        $sql = "insert into quadra(nome, logradouro, numero, bairro, cidade, estado, cep, lat, lng, usuario_id) "
                ."values('$this->nome','$this->logradouro','$this->numero','$this->bairro','$this->cidade','$this->estado','$this->cep','$this->lat','$this->lng','$this->dono')";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }
	
	public function alterar($nome, $logradouro, $numero, $bairro, $cidade, $estado, $cep, $lat, $lng, $id){
        $sql = "update quadra set nome = '$nome', logradouro = '$logradouro', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$estado', cep = '$cep', lat = '$lat', lng = '$lng' where id = $id";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }
	
	public function excluir($id){
        $sql = "delete from usuarios where id = $id";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }
    
	
	public function infoQuadra($id)
	{
        $sql = "SELECT * FROM quadra WHERE id = $id";
        $this->select_quadra = $this->conexao->query($sql);
        return $this->select_quadra;
    }
    public function selectQuadra(){
        $sql = "SELECT * FROM quadra";
        $this->select_quadra = $this->conexao->query($sql);
        return $this->select_quadra;
    }
    
	
    public function dadosQuadra(){
        $this->dados_quadra = $this->select_quadra->fetch_array(MYSQLI_ASSOC);
        return $this->dados_quadra;
    }
	
	
	public function selectServicos($id_quadra){
        $sql = "SELECT SQ.QUADRA_ID, S.NOME FROM servicos S
INNER JOIN servicos_quadra SQ ON SQ.SERVICOS_ID = S.ID WHERE SQ.QUADRA_ID = " . $id_quadra;
        $this->select_servicos = $this->conexao->query($sql);
        return $this->select_servicos;
    }
    
    public function dadosServicos(){
        $this->dados_servicos = $this->select_servicos->fetch_array(MYSQLI_ASSOC);
        return $this->dados_servicos;
    }
	
	public function selectFotos($id_quadra){
        $sql = "SELECT * FROM fotos_quadra FT
INNER JOIN quadra Q ON FT.ID_QUADRA = Q.ID 
WHERE FT.ID_QUADRA = " . $id_quadra;
        $this->select_fotos = $this->conexao->query($sql);
        return $this->select_fotos;
    }
    
    public function dadosFotos(){
        $this->dados_fotos = $this->select_fotos->fetch_array(MYSQLI_ASSOC);
        return $this->dados_fotos;
    }
	
	public function selectHorarios($id_quadra){
        $sql = "SELECT FQ.* FROM funcionamento_quadra FQ
INNER JOIN quadra Q ON FQ.QUADRA_ID = Q.ID WHERE Q.ID = " . $id_quadra;
        $this->select_horarios = $this->conexao->query($sql);
        return $this->select_horarios;
    }
    
    public function dadosHorarios(){
        $this->dados_horarios = $this->select_horarios->fetch_array(MYSQLI_ASSOC);
        return $this->dados_horarios;
    }
	
	public function InfoReserva($id){
		$sql = "SELECT * FROM detalhes_reserva WHERE QUADRA_ID = " . $id;
        $this->select_reserva = $this->conexao->query($sql);
	}
	public function dadosReserva(){
        $this->dados_reserva = $this->select_reserva->fetch_array(MYSQLI_ASSOC);
        return $this->dados_reserva;
	}
	
	public function inserirReserva($dID, $uID){
        $sql = "insert into reserva(detalhes_reserva_ID, USUARIO_ID) values($dID, $uID)";
        $resultado = $this->conexao->query($sql);
        return $resultado;
    }
	
	public function InfoMinhaReserva($id){
		$sql = "SELECT
	R.ID RESERVA_ID,
    DR.*,
    U.NOME USUARIO,
    Q.NOME QUADRA
FROM RESERVA R
	INNER JOIN DETALHES_RESERVA DR ON R.DETALHES_RESERVA_ID = DR.ID
    INNER JOIN USUARIO U ON R.USUARIO_ID = U.ID
    INNER JOIN QUADRA Q ON DR.QUADRA_ID = Q.ID
WHERE U.ID = $id";
	$this->select_reserva = $this->conexao->query($sql);
	}
	public function dadosMinhaReserva(){
        $this->dados_reserva = $this->select_reserva->fetch_array(MYSQLI_ASSOC);
		return $this->dados_reserva;
	}
	
	public function selectMinhaQuadra($id){
        $sql = "SELECT * FROM quadra where USUARIO_ID = $id";
        $this->select_minhaquadra = $this->conexao->query($sql);
        return $this->select_minhaquadra;
    }
    
	
    public function dadosMinhaQuadra(){
        $this->dados_minhaquadra = $this->select_minhaquadra->fetch_array(MYSQLI_ASSOC);
        return $this->dados_minhaquadra;
    }
	
}
?>
