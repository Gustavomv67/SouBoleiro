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
	
	$reserva = $quadra->InfoMinhaReserva($id);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Minhas Reservas - souBoleiro.com</title>
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
                    <a href='minhas_quadras.php'><i class='fa fa-pie-chart'></i>  Minhas Quadras</a>
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
                <div class="row">
					<div id="pesquisa" class="col-lg-12">
						<form name="pesquisa" method="post">
							<a href="#menu-toggle" class="btn btn-md btn-success" id="menu-toggle"><i class="glyphicon glyphicon-menu-hamburger"></i></a>
						</form>
					</div>
                </div>
				
				<div class="col-lg-12">
					<div id="resultado-pesquisa" class="col-xs-10 col-lg-9">
					<?php while($dados = $quadra->dadosMinhaReserva()){ ?>
					<div id="topo-resultado" class="col-lg-12 text-left"><hr>
					<div id="usuario" class="col-xs-12 col-md-12 text-left">
								<h3>Quadra</h3>
								<h5><i class="glyphicon glyphicon-user"> <?php echo $dados['QUADRA'] ?></i></h5>
								</div>
					<div id="usuario" class="col-xs-12 col-md-12 text-left">
								<h3>Usuário</h3>
								<h5><i class="glyphicon glyphicon-user"> <?php echo $dados['USUARIO'] ?></i></h5>
								</div>
					<div id="dia" class="col-xs-12 col-md-12 text-left">
								<h3>Dia</h3>
								<h5><i class="fa fa-calendar"> <?php echo $dados['DIA'] ?></i></h5>
								</div>
					<div id="hora_entrada" class="col-xs-12 col-md-12 text-left">
								<h3>Hora de entrada</h3>
								<h5> <i class="fa fa-hourglass"> <?php echo $dados['HORA_ENTRADA'] ?></i></h5>
								</div>
					<div id="hora_saida" class="col-xs-12 col-md-12 text-left">
								<h3>Hora de saída</h3>
								<h5><i class="fa fa-hourglass-o"> <?php echo $dados['HORA_SAIDA'] ?></i></h5>
					
					</div>
					</div>
					<?php } ?> 
						
						</div>
						
			
			
		</div>
	</div>
				</div>
				
            </div>
        </div>
        <!-- /#page-content-wrapper -->

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
        $("#wrapper").toggleClass("toggled");
		$("#wrapper").toggleClass("overflow");
		$("#googleMap").toggleClass("removeMargin");
    });

	
    </script>
</body>
</html>

	<?php }
	else {
		header("location:index.php");
	}
	?>