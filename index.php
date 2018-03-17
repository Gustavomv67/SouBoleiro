<?php
    include_once 'bd/classUsuario.php';
	if(isset($_POST['logar'])) {
		$usuario = new Usuario();
		$dados = $usuario->logar($_POST['var_login'],md5($_POST['senha']));
		if(!$dados) {
			/* Erro de Login */
			header("location:index.php?erro=1");
		}
		else {
			session_start();
			/* Sucesso de Login */
			$_SESSION['ID'] = $dados['ID'];
			$_SESSION['NOME'] = $dados['NOME'];
			$_SESSION['TIPO'] = $dados['TIPO_USUARIO'];
			if($dados['FOTO_PERFIL'] != "") {
				$_SESSION['FT_USUARIO'] = $dados['FOTO_PERFIL'] ;
			}
			else {
				$_SESSION['FT_USUARIO'] = "home_perfil.png";
			}
			
			header("location:quadras.php");
		}
	
	}

?>
<!DOCTYPE html>
<html lang="pt">
  <head>
  
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>souBoleiro.com</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
	
	<link href="css/pages/index.css" rel="stylesheet">
	
	
	
	<!-- Fonts -->	

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="fundo">
	<script>
  /*window.fbAsyncInit = function() {
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
   }(document, 'script', 'facebook-jssdk'));*/
</script>

	
		<div class="col-xs-12 col-lg-12 text-center">
		<div class="col-md-4"></div>
					<div id="logomarca" class="col-md-8">
						<img src="img/logo-temp.png" class="img-responsive">
					</div>
		
			<div class="col-lg-12">
				<form id="form-login" name="logar" method="post">
					<div class="col-md-4"></div>
					<div id="login" class=" col-xs-12 col-md-4 col-lg-4">
							
							<div class="text-left">
							<div class="inner-addon left-addon form-group">
							<i class="glyphicon glyphicon-user"></i>
								<input name="var_login" type="text" class="form-control inputs" id="email" placeholder="Email ou Apelido" required="required">
							</div>
							<div class="inner-addon left-addon form-group">
							<i class="glyphicon glyphicon-lock"></i>
								<input name="senha" type="password" class="form-control inputs" id="senha" placeholder="Senha" required="required">
							</div>
							<div class="form-group">
							<div id="botao">
					
					<button id="botao-login" onclick="barra()" name="logar" >Partiu!</button>
					
					</div>
					<div id="auxiliares" class="text-left col-xs-3 col-md-3">
						<a id="cadastro" href="cadastro/" class="btn btn-md btn-link">Cadastrar</a>
					</div>
					<div id="auxiliares"class="text-right col-xs-9 col-md-9">
						<a  class="btn btn-md btn-link">Precisa de Ajuda?</a>
					</div>
							<div class="col-xs-12 ">
								<div id="div-progress" class="ocultar-barra progress">
								  <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar">
								  </div>
								</div>
								</div>
							</div>
							</div>
					</div>
					<div class="col-md-4"></div>
					
				</form>
			</div>
		</div>
		</div>
		
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	
	<script>
	//Enviar dados
		var form = document.getElementById("form-login");
		document.getElementById("botao-login").addEventListener("click", function () {
			form.submit();
		});
		
		function barra() { 
		$('#div-progress').removeClass('ocultar-barra');	
		$('#progressbar').css('width',80 + "%");
		
		$('#progressbar').addClass('progress-bar-success');	
		$('#email').removeClass('erro');
		$('#senha').removeClass('erro');
		
		};
		function erro() {
		$('#email').addClass('erro');
		$('#senha').addClass('erro');
		alert("Usuário ou Senha inválidos.");
		};
	</script>
	
	<?php
	if(isset($_GET['erro'])) {
		if($_GET['erro'] == 1) {
	echo "<script type='text/javascript'>erro();</script>";
	}
	}
	
	?>
	
  </body>
</html>