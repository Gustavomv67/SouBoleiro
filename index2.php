<?php
    include_once 'bd/classUsuario.php';
	if(isset($_POST['logar'])) {
		$usuario = new Usuario();
		$dados = $usuario->logar($_POST['var_login'],md5($_POST['senha']));
		if(!$dados) {
			/* Erro de Login */
			header("location:index2.php?erro=1");
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
				$_SESSION['FT_USUARIO'] = "img/home_perfil.jpg";
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
    <title>SOUBOLEIRO</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
	
	<link href="css/pages/index2.css" rel="stylesheet">
	
	
	
	<!-- Fonts -->	
	<link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
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
<div id="fundo">
</div>
	<div id="video">
		<video autoplay loop muted id="background-video">
			<source src="img/football.mp4" type="video/mp4">
			<source src="img/football.webm" type="video/webm">
		</video>
	</div>
	<div id="lateral">
		<div class="col-xs-12 col-lg-12 text-center">
			<div class="col-lg-12">
				<div class="col-md-2"></div>
					<div id="logomarca" class="col-md-8">
						<img src="img/logo-temp.png" class="img-responsive">
					</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-lg-12">
				<form id="form-login" name="logar" method="post">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div id="login">
							<header>
							
							</header>
							
							<div class="inputs text-left">
							<div id="validacao1" class="form-group">
								<label for="exampleInputEmail1">Identifique-se, Boleiro!</label>
								<input name="var_login" type="text" class="form-control" id="exampleInputEmail1" placeholder="Email ou Apelido">
							</div>
							<div id="validacao2" class="form-group">
								<label for="exampleInputPassword1">e sua senha!</label>
								<input name="senha" type="password" class="form-control" id="exampleInputPassword1">
								<div class="text-right">
								<a href="" class="btn-sm btn-link ">Esqueci minha senha :(</a>
								</div>
							</div>
							<div class="form-group">
								<div class="progress">
								  <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar">
								  </div>
								</div>
							</div>
							</div>
						</div>
					</div>
					<div class="col-md-3"></div>
					<div id="botao" class="col-md-12">
					<a href="2/cadastro.php" class="btn btn-md btn-link">Não possui cadastro?</a>
					<button id="botao-login" onclick="barra()" name="logar" >Partiu!</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- Personal JavaScript for SouBoleiro.com -->
    <script src="js/souboleiro.js"></script>
	<script>
		$("#exampleInputEmail1").click(function() {
			alert('teste');
		});
			
		</script>
	<script>
	//Enviar dados
		var form = document.getElementById("form-login");
		document.getElementById("botao-login").addEventListener("click", function () {
			form.submit();
		});
		
		function barra() { 
		$('#progressbar').css('width',80 + "%");
		$('#progressbar').removeClass('progress-bar-danger');		
		$('#progressbar').addClass('progress-bar-success');	
		$('#validacao1').removeClass('has-error has-feedback');
		$('#validacao2').removeClass('has-error has-feedback');
		
		};
		function erro() {
		$('#progressbar').removeClass('progress-bar-success');		
		$('#progressbar').addClass('progress-bar-danger');	
		$('#progressbar').css('visibility','hidden');
		$('#validacao1').addClass('has-error has-feedback');
		$('#validacao2').addClass('has-error has-feedback');
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