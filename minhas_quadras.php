<?php
	session_start();
	if(isset($_SESSION['ID'])) {
	$id = $_SESSION['ID'];
	$nome = $_SESSION['NOME'];
	$tipo_usuario = $_SESSION['TIPO'];
	$foto_perfil = $_SESSION['FT_USUARIO'];
	echo "<script type='text/javascript'>var nome = '$nome';</script>";
	
    include_once 'bd/classQuadra.php';
	
    $quadra = new Quadra();
	
	$resultado = $quadra->selectMinhaQuadra($id);
	
	if(isset($_POST['enviar'])){
		if($_POST['idquadra'] != ""){
			$quadra->alterar($_POST['nome'], $_POST['logradouro'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'], $_POST['lat'], $_POST['lng'], $_POST['idquadra']);
			$resultado = $quadra->selectMinhaQuadra($id);
		}
		else{
			$quadra = new Quadra('', $_POST['nome'], $_POST['logradouro'], $_POST['numero'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['cep'], $_POST['lat'], $_POST['lng'], $id);
			$resultado = $quadra->inserir();
			$resultado = $quadra->selectMinhaQuadra($id);
		}		
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Minhas Quadras</title>
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
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<script language="JavaScript" type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=en"></script>
	
	<link rel="stylesheet" type="text/css" href="css/pages/quadras.css" />
	<!--[if IE]>
		<script type="text/javascript">
			 var console = { log: function() {} };
		</script>
	<![endif]-->
	
</head>
<body>
<div id="wrapper" class="minhas-quadras">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
		<div class="imagem-responsiva">
		<div id="img-perfil"></div>
		</div>
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                        Bem vindo, <?php echo $nome; ?>
                </li>
              <li>
                    <a href="quadras.php"><i class="glyphicon glyphicon-home"></i> Início</a>
                </li>
                <li>
                    <a href="perfil.php"><i class="glyphicon glyphicon-user"></i> Perfil</a>
                </li>
                <li>
                    <a href="minhas_reservas.php"><i class="glyphicon glyphicon-calendar"></i> Minhas Reservas</a>
                </li>
               <?php if($tipo_usuario >= 1) {
					echo "<li>
                    <a href='minhas_quadras.php'><i class='fa fa-pie-chart'></i> Minhas Quadras</a>
                </li>";
				}
				?>
                <li>
                    <a href="contato.php"><i class="glyphicon glyphicon-question-sign"></i> Contato</a>
                </li>
				<?php if($tipo_usuario == 2) {
					echo "<li>
                    <a href='#'><i class='fa fa-lock'></i> Administração</a>
                </li>";
				}
				?>
                <li>
                    <a href="logout.php"><i class="fa fa-sign-out"></i> <b>Sair</b></a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
		
<div id="page-content-wrapper">
	<div class="container-fluid">
	<a href="#menu-toggle" class="btn btn-md btn-default" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
		<div class="row">
		<div id="escurecer" class="mostrar">
		<button id="fechar">X</button>
	<div class="col-md-10"><h1></h1></div>
	<div class="col-md-2"></div>

	<div class="col-md-12">
	<div id="titulo_quadra"></div>
	<hr>
	
	<form id="alt-cad" name="alt-cad" method="post">
		
		<div class="form-group col-xs-12 col-md-3">
			<label>Nome</label>
			<input type="text" class="input form-control" id="nome" name="nome">
		</div>
		<div class="form-group col-xs-12 col-md-4">
			<label>Endereço</label>
			<input type="text" class="input form-control" id="logradouro" name="logradouro">	
		</div>
		<div class="form-group col-xs-12 col-md-1">
			<label>Número</label>
			<input type="text" class="input form-control" id="numero" name="numero">	
		</div>
		<div class="form-group col-xs-12 col-md-3">
			<label>Bairro</label>
			<input type="text" class="input form-control" id="bairro" name="bairro">	
		</div>
		<div class="form-group col-xs-12 col-md-3">
			<label>Cidade</label>
			<input type="text" class="input form-control" id="cidade" name="cidade">	
		</div>
		<div class="form-group col-xs-12 col-md-1">
			<label>Estado</label>
			<input type="text" class="input form-control" id="estado" name="estado">	
		</div>
		<div class="form-group col-xs-12 col-md-2">
			<label>CEP</label>
			<input type="text" class="input form-control" id="cep" name="cep">	
		</div>
		
		<div class="form-group col-xs-12 col-md-2" style="display:none;">
			<input type="text"id="idquadra" name="idquadra">
		</div>
		<div class="form-group col-xs-12 col-md-12"></div>
		<div class="form-group col-xs-12 col-md-2">
			<a href="javascript:void(0);" onclick="buscaEndereco();" class="btn btn-md btn-default">Buscar Endereco</a>
		</div>
		
		<div class="form-group col-xs-12 col-md-7">
			<input type="text" class="input form-control" id="end" name="end" disabled>
		</div>
		<div class="form-group col-xs-12 col-md-2">
			<input type="text" class="input form-control" id="lat" name="lat" style="display:none;">
		</div>
		<div class="form-group col-xs-12 col-md-2">
			<input type="text" class="input form-control" id="lng" name="lng" style="display:none;">
		</div>
		
		
		<div class="form-group col-xs-12 col-md-12">
			<input type="submit" class="btn btn-md btn-default" id="enviar" name="enviar">	
		</div>
		
	</form>
	
	</div>
	</div>
	
	
	
	<div id="corpo-row">
			<div class="col-xs-12 col-lg-12">
			
			
				<div id="topo-resultado" class="col-lg-12">
					<div class="text-left" style="float:left;">
					<h1>Minhas Quadras</h1>
					</div>
					<div class="text-right">
					<button onClick="abrir();" class="btn btn-md btn-success">Cadastrar</button>
					</div>
					<hr>
				</div>
				
				
				
				
				<?php while($dados = $quadra->dadosMinhaQuadra()){
					$array_quadra[$dados['ID']] = array("id" => $dados['ID'], "nome" => $dados['NOME'], "logradouro" => $dados['LOGRADOURO'], "numero" => $dados['NUMERO'],"bairro" => $dados['BAIRRO'], "cidade" => $dados['CIDADE'], "estado" => $dados['ESTADO'], "cep" => $dados['CEP']);
				
				?>
					<div class="col-xs-12 col-md-4 ">
							<header>
								<h2> <?php echo $dados['NOME']; ?></h2>
							</header>
						<div id="quadra" style="background-image:url(img/quadras/quadra1.jpg);">
							<a id="<?php echo $dados['ID']; ?>" href="javascript:void(0);" onclick="carregarQuadras(this.id);"><div class="mask text-center">  
								<i class="glyphicon glyphicon-question-sign"></i>  
							</div>
							</a>
						</div>

						
						
					</div>
				<?php } 
				if(isset($array_quadra)) {
					$jsonQuadras = json_encode($array_quadra);
				}
				else {
					$jsonQuadras = "0";
				}
				?>
				
		</div>
	</div>
	</div>
	
</div>
</div>
	
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
	<?php 
	echo "var array_quadras = $jsonQuadras; \n";
	?>
	
	function carregarQuadras($id){		
		
		abrir();
		
		$("#titulo_quadra").html('<h1>Editar <b>'+array_quadras[$id].nome+'</b></h1>');
		
		
		$("#idquadra").val(array_quadras[$id].id);
		$("#nome").val(array_quadras[$id].nome);
		$("#logradouro").val(array_quadras[$id].logradouro);
		$("#numero").val(array_quadras[$id].numero);
		$("#bairro").val(array_quadras[$id].bairro);
		$("#cidade").val(array_quadras[$id].cidade);
		$("#estado").val(array_quadras[$id].estado);
		$("#cep").val(array_quadras[$id].cep);
		$("#enviar").val("Alterar");
		
		
}

function abrir() {
		$('#alt-cad').trigger("reset");
		$("#titulo_quadra").html('<h1>Cadastrar Quadra</h1>');
		$("#enviar").val("Cadastrar");
		$("#escurecer").fadeIn(300);
		$("#corpo-row").addClass("embacar");
		$("#wrapper").addClass("overflow");
}
	$(document).ready(function() {
		$("#img-perfil").css('background-image',<?php echo "'url(img/users/$foto_perfil)'"; ?>);
		
	});
	
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
		$("#wrapper").toggleClass("overflow");
		$("#googleMap").toggleClass("removeMargin");
    });
	
	$("#fechar").click(function(e) {
        $("#escurecer").fadeOut(300);
		$("#corpo-row").removeClass("embacar");
		$("#wrapper").removeClass("overflow");
    });
	
	function buscaEndereco() {
		var logra = $("#logradouro").val();
		var num = $("#numero").val();
		var bai = $("#bairro").val();
		var cid = $("#cidade").val();
		var est = $("#estado").val();
		
		
		var address = logra + ", " + num + " - " + bai + ", " + cid + " - " + est;
		addressToLocation(address);
	}
	
	// converting the address's string to a google.maps.LatLng object
			function addressToLocation(address) {
				var geocoder = new google.maps.Geocoder();
				geocoder.geocode(
					{
						address: address
					}, 
					function(results, status) {
						
						var resultLocations = [];
						
						if(status == google.maps.GeocoderStatus.OK) {
							if(results) {
								var text = results[0].formatted_address;
								var lat = results[0].geometry.location.lat();
								var lng = results[0].geometry.location.lng();
								
								$("#end").val(text);
								$("#lat").val(lat);
								$("#lng").val(lng);
								}
						} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
							// address not found
						}
						
					}
				);
				
			}
    </script>
</body>
</html>

	<?php }
	else {
		header("location:index.php");
	}
	?>