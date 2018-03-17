<?php
	session_start();
	if(isset($_SESSION['ID'])) {
	$id = $_SESSION['ID'];
	$nome = $_SESSION['NOME'];
	$tipo_usuario = $_SESSION['TIPO'];
	$foto_perfil = $_SESSION['FT_USUARIO'];
	
	
    include_once 'bd/classUsuario.php';
	include_once 'bd/classLocal.php';
    
	
	
	/* Classe Usuario */
	
	$usuario = new Usuario();
	
	$resultadousuario = $usuario->selectUsuario($id);
	$dados = $usuario->dadosUsuario();
	
	$resultadotime = $usuario->selectTime();
	$resultadopos = $usuario->selectPosicao();
	
	
	$dia = date("d", strtotime($dados['DT_NASCIMENTO']));
	$mes = date("m", strtotime($dados['DT_NASCIMENTO']));
	$ano = date("Y", strtotime($dados['DT_NASCIMENTO']));
	
	/* Classe Local */
	
	$local = new Local();

	$resultadoestado = $local->selectEstado();
	$resultadocidade = $local->selectCidade();
	
	while($dadoestado = $local->dadosEstado()) {
	$estados[] = array("id" => $dadoestado['est_id'], "uf" => $dadoestado['est_uf']);		
	}
	while($dadocidade = $local->dadosCidade()) {
		
	$cidades[$dadocidade['est_id']][] = array("id" => $dadocidade['cid_id'], "nome" => $dadocidade['cid_nome']);		
	}	
	
	$jsonEstados = json_encode($estados);
	$jsonCidades = json_encode($cidades);
	
	/* Metodo Alterar */
	
	if(isset($_POST['alterar'])){
		$data = $_POST['ano'] . "/" . $_POST['mes'] . "/" . $_POST['dia'];
		$usuario->alterar($_POST['nome'], $_POST['sobrenome'], $_POST['sexo'], $_POST['ddd'], $_POST['celular'], $_POST['email'], $data, $_POST['endereco'],$_POST['cidade'], $_POST['estado'], $_POST['apelido'], $_POST['time'], $_POST['posicao'], $_SESSION['ID']);
		$resultadousuario = $usuario->selectUsuario($id);
		$dados = $usuario->dadosUsuario();
	}
?>

<script>

<?php
        echo "var estados = $jsonEstados; \n";
        echo "var cidades = $jsonCidades; \n";
		echo "var cid = " . $dados['ID_CIDADE'] .";";
		echo "var est = " . $dados['ID_ESTADO'] .";";
		
		
 ?>
 
function loadCategories(){
        var drop_estado = document.getElementById("drop_estado");
		var drop_cidade = document.getElementById("drop_cidade");
		drop_estado.onchange = carregacity;
		drop_estado.onclick = carregacity;
        for(var i in estados){
          drop_estado.options[i] = new Option(estados[i].uf,estados[i].id);          
        }
		$("#drop_estado")[0].selectedIndex = est -1 ;
		for(var i = 0; i <= cidades[est].length; i++) {
			if(cidades[est][i].id == cid) {
				$("#drop_cidade").append('<option value='+cid+'>'+cidades[est][i].nome+'</option>');
			}
		}
		
}

	 function carregacity() {
		 var index = $("#drop_estado")[0].selectedIndex + 1;
			var drop_cidade = document.getElementById("drop_cidade");
			
			drop_cidade.options.length = 0; //delete all options if any present
			
			for(var i = 0; i < cidades[index].length; i++){
			drop_cidade.options[i] = new Option(cidades[index][i].nome,cidades[index][i].id);
			}
			
};
</script>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="ISO-8859-1" />
	<title>Perfil - souBoleiro.com</title>
	<meta name="author" content="Lucas Tomaz Resende Miranda" />
	<meta name="description" content="Portfolio do Aplicativo Boleiros" />
	<meta name="keywords"  content="marca pelada, pelada, busca pelada, marca futebol, futbolzin, marcar futbol, marcador de pelada, busca quadra, quadra próxima, aplicativo de futebol" />
	<meta name="Resource-type" content="Document" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	<link rel="stylesheet" type="text/css" href="css/pages/perfil.css" />
	<!--[if IE]>
		<script type="text/javascript">
			 var console = { log: function() {} };
		</script>
	<!--[endif]-->
	
</head>
<body onload='loadCategories()'>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1689279417958750',
      xfbml      : true,
      version    : 'v2.4'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div id="wrapper">

        
        <div id="sidebar-wrapper">
		<div class="imagem-responsiva">
		<div id="img-perfil"></div>
		</div>
            <ul class="sidebar-nav">
                
                <li>
                    <a href="quadras.php"><i class="glyphicon glyphicon-home"></i> In&iacute;cio</a>
                </li>
                <li>
                    <a href="perfil.php"><i class="glyphicon glyphicon-user"></i> Perfil</a>
                </li>
                <li>
                    <a href="minhas_reservas.php"><i class="glyphicon glyphicon-calendar"></i> Minhas Reservas</a>
                </li>
               <?php if($tipo_usuario >= 1) {
					echo "<li>
                    <a href='minhas_quadras.php'><i class='fa fa-pie-chart'></i>  Minhas Quadras</a>
                </li>";
				}
				?>
                <li>
                    <a href="contato.php"><i class="glyphicon glyphicon-question-sign"></i> Contato</a>
                </li>
				<?php if($tipo_usuario == 2) {
					echo "<li>
                    <a href='#'><i class='fa fa-lock'></i> Administra&ccedil;&atilde;o</a>
                </li>";
				}
				?>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out"></i> <b>Sair</b></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
<div id="topo">
		<a href="#menu-toggle" class="btn btn-md btn-default" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
		<h1><?php echo $dados['NOME'] . " " . $dados['SOBRENOME']; ?></h1>
		</div>
        <!-- Page Content -->
		
        <div id="page-content-wrapper">
		
		
            <form name="usuario" method="post" action="perfil.php">
	<div class="container-fluid">
	
		<div class="row text-left">
		
			<div id="corpo" class="col-lg-12">
				
				<div id="blocos" class="col-xs-12 col-md-6 col-lg-6">
				Sobre voc&ecirc;
				<hr>
					<div class="form-group col-xs-8 col-md-3">
						<label>Nome</label>
						<input type="text" value="<?php echo $dados['NOME'];?>" class="form-control" id="email" placeholder="Ex.: Jo&atilde;o" name="nome">
					</div>
					<div class="form-group col-xs-12 col-md-8">
						<label>Sobrenome</label>
						<input type="text" value="<?php echo $dados['SOBRENOME'];?>" class="form-control" id="sobrenome" placeholder="da Silva Santos" name="sobrenome">
					</div>
					<div class="form-group col-xs-12">
					<label>Sexo</label><br>
						<label class="radio-inline">
							<input type="radio" name="sexo" value="M" <?php if($dados['SEXO'] == "M"){ echo "checked";}?>> Masculino
						</label>
						<label class="radio-inline">
							<input type="radio" name="sexo" value="F" <?php if($dados['SEXO'] == "F"){ echo "checked";}?>> Feminino
						</label>
					</div>
					
					<div class="form-group col-xs-4 col-md-4">
					<label>DDD</label>
					<input type="phone" value="<?php echo $dados['DDD'];?>" class="form-control" id="ddd" placeholder="DDD" name="ddd">	
					</div>
					
					<div class="form-group col-xs-8 col-md-8">
					<label>Celular</label>
					<input type="phone" value="<?php echo $dados['CELULAR'];?>" class="form-control" id="celular" placeholder="Celular" name="celular">
					</div>
					
					<div class="form-group col-xs-12 col-md-12">
					<label>Email</label>
					<input type="email" value="<?php echo $dados['EMAIL'];?>" class="form-control" id="email" placeholder="Ex.: seuemail@servidor.com" name="email">
					</div>
					
					<div class="form-group col-xs-12 text-left">
					<label>Data de Nascimento</label><br>
						<div class="col-xs-3">
						<select name="dia" class="form-control" required="required">
						<option></option>
							<?php for($i = 1; $i <= 31; $i++) {
							if($i == $dia) {
									echo "<option value='$i'selected>$i</option>";
							}	
							echo "<option value='$i'>$i</option>";
							}
							?>
						</select>
						</div>
						<div class="col-xs-5">
						<select name="mes" class="form-control" required="required">
							<option></option>
							<option value='1' <?php if($mes == 1) {echo"selected";} ?>>Janeiro</option>
							<option value='2' <?php if($mes == 2) {echo"selected";} ?>>Fevereiro</option>
							<option value='3' <?php if($mes == 3) {echo"selected";} ?>>Março</option>
							<option value='4' <?php if($mes == 4) {echo"selected";} ?>>Abril</option>
							<option value='5' <?php if($mes == 5) {echo"selected";} ?>>Maio</option>
							<option value='6' <?php if($mes == 6) {echo"selected";} ?>>Junho</option>
							<option value='7' <?php if($mes == 7) {echo"selected";} ?>>Julho</option>
							<option value='8' <?php if($mes == 8) {echo"selected";} ?>>Agosto</option>
							<option value='9' <?php if($mes == 9) {echo"selected";} ?>>Setembro</option>
							<option value='10'<?php if($mes == 10) {echo"selected";} ?>>Outubro</option>
							<option value='11'<?php if($mes == 11) {echo"selected";} ?>>Novembro</option>
							<option value='12'<?php if($mes == 12) {echo"selected";} ?>>Dezembro</option>
						</select>
						</div>
						<div class="col-xs-4">
						<select name="ano" class="form-control" required="required">
						<option></option>
						<?php for($i = 1930; $i <= 2015; $i++) {
							if($i == $ano) {
									echo "<option value='$i'selected>$i</option>";
							}	
							echo "<option value='$i'>$i</option>";
							}
							?>
						</select>
						</div>
					</div>
					
					<div class="form-group col-xs-12 col-md-12">
						<label>Endere&ccedil;o</label>
						<input name="endereco" type="text" value="<?php echo $dados['ENDERECO'];?>" class="form-control" id="endereco" placeholder="Endere&ccedil;o">
					</div>
					
					<div class="form-group col-xs-4 col-md-4">
					<label>Estado</label><br>
					
						<select id="drop_estado" name="estado" class="form-control" required="required">
						
						</select>
					</div>
					
					<div class="form-group col-xs-8 col-md-8">
						<label>Cidade</label>
						<select id="drop_cidade" name="cidade" class="form-control" required="required" >
						
						</select>
						</div>
					
					
					
				</div>
				
				<div id="blocos" class="col-xs-12 col-md-6 col-lg-6">
				Sobre voc&ecirc e seu time
				<hr>
				<div class="form-group col-xs-12 col-md-9">
						<label>Qual seu Apelido?</label>
						<input name="apelido" type="text" value="<?php echo $dados['APELIDO'];?>" class="form-control" id="apelido" placeholder="Ex.: Jo&atilde;ozinho">
						<p>Obs.: Digite como deseja ser chamado.</p>
					</div>
					<div class="form-group col-xs-12 col-md-8">
						<label>Qual seu time do cora&ccedil&atildeo?</label>
						<div class="input-group">
						<select name="time" class="form-control" required="required">
						<?php 
								while($dadostime = $usuario->dadosTime()){
										if($dadostime['ID'] == $dados['ID_TIME']) {
											echo "<option value='" . $dadostime['ID'] . "' selected>". $dadostime['NOME'] ."</option>";
										}
										
										echo "<option value='" . $dadostime['ID'] . "'>". $dadostime['NOME'] ."</option>";
									}
								
						?>
						
						</select>
						<div class="input-group-addon"><img src="img/home_perfil.jpg" class="img-circle" style="width:19px;"></div>
						</div>
					</div>
					<div class="form-group col-xs-12 col-md-8">
						<label>Em qual posi&ccedil;&atilde;o voc&ecirc; joga?</label>
						<select name="posicao" class="form-control" required="required">
						<?php 
								while($dadosposicao = $usuario->dadosPosicao()){
										if($dadosposicao['ID'] == $dados['ID_POSICAO']) {
											echo "<option value='" . $dadosposicao['ID'] . "' selected>". $dadosposicao['NOME'] ."</option>";
										}
										echo "<option value='" . $dadosposicao['ID'] . "'>". $dadosposicao['NOME'] ."</option>";
									}
								
						?>
						</select>
					</div>
					
				</div>
				
				<div id="blocos" class="col-xs-12 col-md-6 col-lg-6"><br>
				<div class="form-group col-xs-12 col-md-12 text-center">
				<input name="alterar" class="btn btn-lg btn-success" value="Alterar Dados" type="submit"></input>
				</div>
					<div class="form-group col-xs-12 col-md-12">
						<div
  class="fb-like"
  data-share="true"
  data-width="250"
  data-show-faces="true">
</div>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</form>
    </div>
    <!-- /#wrapper -->
	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
	
	$(document).ready(function() {
		$("#img-perfil").css('background-image',<?php echo "'url(img/users/$foto_perfil)'"; ?>);
		
	});
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
		$("#wrapper").toggleClass("removeOverflow");
		$("#wrapper").toggleClass("overflow");
        $("#wrapper").toggleClass("toggled");
		
    });
	
    </script>
</body>
</html>

	<?php }
	else {
		header("location:index.php");
	}
	?>