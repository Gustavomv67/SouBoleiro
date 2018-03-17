<?php 

include_once '../bd/classLocal.php';
include_once '../bd/classUsuario.php';
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
	
	if (isset($_POST['enviar'])) {
		
			$usuario = new Usuario('', $_POST['nome'], $_POST['sobrenome'], $_POST['sexo'], $_POST['ddd'], $_POST['celular'], $_POST['email'],$_POST['dt_nascimento'], '', $_POST['cidade'], $_POST['estado'], '', '', '', '', md5($_POST['senha']), '', $_POST['tipo_usuario']);
			
		
		$resultadoEmail = $usuario->VerificaEmail($_POST['email']);
		if($resultadoEmail){
			header("location:index.php?erro=1");
		}
		else{
			$resultado = $usuario->inserir();
			header('location:../index.php');
		}
	}

?>

<script>

<?php
        echo "var estados = $jsonEstados; \n";
        echo "var cidades = $jsonCidades; \n";
		
		
 ?>
 
function loadCategories(){
        var drop_estado = document.getElementById("drop_estado");
		var drop_cidade = document.getElementById("drop_cidade");
		drop_estado.onchange = carregacity;
		
        for(var i in estados){
          drop_estado.options[i] = new Option(estados[i].uf,estados[i].id);          
        }	
	}

	 function carregacity(){
		var drop_cidade = document.getElementById("drop_cidade");
		var est = document.getElementById("drop_estado").selectedIndex + 1;
		drop_cidade.options.length = 0; //delete all options if any present
		
		for(var i = 0; i < cidades[est].length; i++){
			drop_cidade.options[i] = new Option(cidades[est][i].nome,cidades[est][i].id);
		}	
	}
</script>

<!DOCTYPE html>
<html lang="pt">
  <head>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Cadastro - souBoleiro.com</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.css" rel="stylesheet">
	
	<link href="cadastro.css" rel="stylesheet">
	
	
	<!-- Fonts 	
	<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!--[endif]-->
</head>
<body onload="loadCategories()">
	
		<div id="topo" class="topo">
			<div class="col-lg-12">
				<div class="col-md-1"><a href="../index.php"><i class="glyphicon glyphicon-chevron-left"></i></a></div>
				<div class="col-md-10 text-center"><h1>Cadastro <b>souBoleiro.com</b></h1></div>
				<div class="col-md-1"></div>
			</div>
		</div>
		<div id="fundo-topo">
		
		<div id="corpo" class="col-lg-12">
		<div class="col-md-6">
			<div id="bloco" class="col-md-11 col-lg-11">
			<header>
				<h1>Cadastre-se utilizando</h1>
			</header>
			<div class="col-md-12">
				<div class="col-md-4"><a href="https://www.facebook.com/dialog/oauth?client_id=1689279417958750&redirect_uri=http://souboleiro.com/cadastro/index.php&scope=email,public_profile,user_friends"><img id="social" src="../img/fb-login.png" class="img-responsive"></a></div>
				<div class="col-md-4"><img id="social" src="../img/google-login.png" class="img-responsive"></div>
				<div class="col-md-4"><img id="social" src="../img/twitter-login.png" class="img-responsive"></div>
			</div>
			
			
			</div>
			
			<div id="bloco" class="col-md-11 col-lg-11">
			<header>
				<h1>Aqui você pode:</h1>
			</header>
			<div class="col-md-12">
				<div class="col-md-12">
				<div class="media">
  <div class="media-left">
      <img class="media-object" src="../img/calendario.png" style="width:105px; "class="img-responsive">
  </div>
  <div class="media-body text-justify">
    <h4 class="media-heading">Marcar sua pelada!</h4>
    Ligar? Marcar pessoalmente? Nunca mais! Com o <b>souBoleiro.com</b> você marca sua pelada, convida seus amigos, e ainda encontra as quadras próximas incluíndo seu preço e os serviços oferecidos.
  </div>
</div>
				
				</div>
			</div>
			
			
			</div>
			</div>
			
			<div id="bloco" class="col-md-5 col-lg-5">
			<header>
				<h1>... ou digite seus dados</h1>
			</header>
			<form action="index.php" name="cadastro" method="post">
			
				<div class="form-group col-xs-5 col-md-4">
				<label>Nome</label>
					<input type="text" name="nome" placeholder="" class="form-control" required="required">
				</div>
				
				<div class="form-group col-xs-9 col-md-8">
				<label>Sobrenome</label>
					<input type="text" name="sobrenome" placeholder="" class="form-control" required="required">
				</div>
				
				<div class="form-group col-xs-4 col-md-4">
				<label>Sexo</label>
					<select name="sexo" class="form-control" required="required">
						<option></option>
							<option value="M".>Masculino</option>
							<option value="F">Feminino</option>
						</select>
				</div>
				
				<div class="form-group col-xs-3 col-md-3">
				<label>DDD</label>
					<input type="text" name="ddd" id="ddd" class="form-control" required="required" placeholder="(__)">
				</div>
				
				<div class="form-group col-xs-9 col-md-4">
				<label>Celular</label>
					<input type="text" name="celular" id="celular" class="form-control" required="required" placeholder="____-____">
				</div>
				
				<div class="form-group col-xs-12 text-left">
					<label>Data de Nascimento</label><br>
						<input type="text" name="dt_nascimento" id="dt_nascimento" class="form-control" required="required">
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
				
				<div class="form-group col-xs-12 col-md-12"></div>
				
				<div class="form-group col-xs-7 col-md-7">
				<label>Email</label>
					<input type="email" name="email" placeholder="" class="form-control" required="required">
				</div>
				<div class="form-group col-xs-7 col-md-6">
				<label>Senha</label>
					<input type="password" id="senha" name="senha" placeholder="" class="form-control" required="required">
				</div>
				<div class="form-group col-xs-7 col-md-6">
				<label>Confirme a senha</label>
					<input type="password" name="senha2" id="senha2" placeholder="" class="form-control" required="required">
				</div>
				
				
					<div class="form-group col-xs-8 col-md-8">
						<label>Tipo de Usuario</label>
						<select  name="tipo_usuario" class="form-control" required="required" >
							<option value="0">Jogador</option>
							<option value="1">Dono de Quadra</option>
						</select>
						</div>
					<div class="form-group col-xs-12 col-md-12 text-right">
						<input type="submit" name="enviar" value="Continuar" class="btn btn-md btn-success">
					</div>
				
			</form>
			
			</div>
			
			
		
		</div>
		
		</div>
		
		
	
	
	
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="../js/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../js/bootstrap.min.js"></script>
		
		<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
	
	<script>
	jQuery(function($){
   $("#dt_nascimento").mask("99/99/9999");
   $("#ddd").mask("(99)");
   $("#celular").mask("9999-9999");
});
		
	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop();
		var padding = 400 - (scrollTop * 2.5);
		var fading = scrollTop / 50;
		
		if(scrollTop >= 0 && scrollTop <=200){
			$("#fundo-topo").css('paddingTop', padding + "px") // Subtract h from scrollTop
			
			$("#topo").css('opacity',fading);
		}
	});
	
	
	$("#senha").blur(function(){
		if($(this).val() == "") {
			$(this).css({'border':'1px solid red'});
			$(this).focus();
			$(this).attr("placeholder", "Digite uma senha válida!");
		}
	});
	$("#senha2").keyup(function(){
		if($(this).val() == $("#senha").val()) {
			$(this).css({'border':'1px solid green'});
			$("#senha").css({'border':'1px solid green'});
		}
		else {
			$(this).css({'border':'1px solid red'});
		}
	});
		function email() {
			alert("Este email já está sendo utilizado.")
			$("#email").css({'border':'1px solid red'});
		}
		
	
	<?php
	if(isset($_GET['erro'])) {
		if($_GET['erro'] == 1) {
	echo "email();";}
	}
	?>
		</script>

	</body>
</html>