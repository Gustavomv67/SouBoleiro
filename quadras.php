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
	
	$resultado2 = $quadra->selectQuadra();
	
	
	$array_quadra = array();
		
		
	while($dados = $quadra->dadosQuadra()){ 
	$resultado3 = $quadra->selectFotos($dados['ID']);
	$dadosfotos = $quadra->dadosFotos();
	
		$row_array['id'] = $dados['ID'];
		$row_array['nome'] = $dados['NOME'];
		$row_array['logradouro'] = $dados['LOGRADOURO'];
		$row_array['numero'] = $dados['NUMERO'];
		$row_array['bairro'] = $dados['BAIRRO'];
		$row_array['lat'] = $dados['LAT'];
		$row_array['lng'] = $dados['LNG'];
		$row_array['foto_quadra'] = $dadosfotos['ID'];
		
		array_push($array_quadra,$row_array);
		
	}
	echo "<script type='text/javascript'>var json = '" . json_encode($array_quadra) . "'; </script>";
	
	$resultado = $quadra->selectQuadra();
	

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<title>Buscar Quadras - souBoleiro.com</title>
	<meta name="author" content="Lucas Tomaz Resende Miranda" />
	<meta name="description" content="Portfolio do Aplicativo Boleiros" />
	<meta name="keywords"  content="marca pelada, pelada, busca pelada, marca futebol, futbolzin, marcar futbol, marcador de pelada, busca quadra, quadra próxima, aplicativo de futebol" />
	<meta name="Resource-type" content="Document" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="css/pages/quadras.css" />
	<!--[if IE]>
		<script type="text/javascript">
			 var console = { log: function() {} };
		</script>
	<![endif]-->
	
		
	<!-- jQuery -->
	  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" src="js/currency-autocomplete.js"></script>
	 <style type="text/css">
	 html {
	height: 100%;
}

.gm-style-iw {
	top: 15px !important;
	left: 0px !important;
	background-color: #fff;
	border: 1px solid #67CD08;
	border-radius: 2px 2px 10px 10px;
}
#iw-container {
	margin-bottom:10px;
	width: 100%;
}
#iw-container .iw-title {
	font-family: 'Open Sans Condensed', sans-serif;
	font-size: 22px;
	font-weight: 400;
	padding: 10px;
	background-color: #67CD08;
	color: white;
	margin: 0;
	border-radius: 2px 2px 0 0;
}
#iw-container .iw-content {
	font-size: 13px;
	line-height: 18px;
	font-weight: 400;
	padding: 15px 10px 0px 15px;
	overflow-y: auto;
	overflow-x: hidden;
}
@media(max-width:768px) {
.iw-content img {
	float: right;
	margin: 0px 15px 5px -5px;	
}

}
.iw-subTitle {
	font-size: 16px;
	font-weight: 700;
	padding: 5px 0;
}
 </style>
</head>
<body>
<div id="wrapper">

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
<div id="topo">
		<a href="#menu-toggle" class="btn btn-md btn-default" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a><h4>Quadras</h4>
		</div>
        <!-- Page Content -->
		
        <div id="page-content-wrapper">
		
            <div class="container-fluid">
                <div class="row">
				
					<div id="pesquisa" class="col-xs-12 col-lg-12">
						<div class="col-xs-1 col-md-2"></div>
						<div class="col-xs-12 col-md-8">
						<input type="text" name="currency" class="biginput input-pesquisa" id="autocomplete" placeholder="Pesquise por quadras ou endereço...">
						
						<div id="outputbox">
  
						</div>
						</div>
						 
  
					</div>
                </div>
				
				
            </div>
        </div>
		<div id="googleMap"></div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

	    

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
	$(document).ready(function() {
		$("#img-perfil").css('background-image',<?php echo "'url(img/users/$foto_perfil)'"; ?>);
		
	});
	
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
		$("#wrapper").toggleClass("overflow");
		$("#googleMap").toggleClass("removeMargin");
    });
	
	var parsed = JSON.parse(json);

	var quadras = [];

	for(var x in parsed){
		var id = parsed[x]['id'];
		quadras[id] = parsed[x];
	}	
	
	function send($id) {
		id_mapa = $id;
	}
	
    </script>
	

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
	<script type="text/javascript" src="js/principal.js"></script>
</body>
</html>

	<?php }
	else {
		header("location:index.php");
	}
	?>