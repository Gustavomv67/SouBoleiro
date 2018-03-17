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
	
	$resultado = $quadra->infoQuadra($_GET ['id']);
	$reserva = $quadra->infoReserva($_GET ['id']);
	

	if(isset($_POST['reservar'])){
		$inserir = $quadra->inserirReserva($_POST['defhorario'], $id);
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Detalhes da Quadra - souBoleiro.com</title>
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
                    <a href='#'><i class='fa fa-lock'></i> Administra&ccedil;o</a>
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
					<div id="topo-resultado" class="col-lg-12 text-left">
					<?php while($dados = $quadra->dadosQuadra()){ ?>
						<h2 id="nome"> <?php echo $dados['NOME'] ?></h2>
						<hr>
					</div>
					
						<div id="<?php echo $dados['ID'] ?>" class=" quadra col-xs-12 col-lg-4">
							<div class="col-xs-12 col-md-12">
								<img src="img/quadras/quadra1.jpg" class="img-responsive">
							</div>
			
							<div id="servicos" class="col-xs-12 col-md-12 text-left">
								<h3>Local</h3><hr>
								<h5><i class="glyphicon glyphicon-map-marker"> <?php echo $dados['LOGRADOURO'] ?></i></h5>
								
								<br>
							</div>
			
			
			
			<div class="form-group ">
			<form action="" method="post">
						<label>Definir Hor&aacute;rio</label>
						
						<select name="defhorario" class="form-control" required="required" >
						<?php while($dadosReservar = $quadra->dadosReserva()){
							 $reservar = $dadosReservar['DIA'] . ", " . $dadosReservar['HORA_ENTRADA'] . " - " . $dadosReservar['HORA_SAIDA'];
							echo "<option value='" . $dadosReservar['ID'] . "'>". $reservar ."</option>";
						}
						?>
						</select>
						<br>
						<input type="submit" value="Reservar Quadra" name="reservar"class="btn btn-md btn-success">
			</form>
						</div>
						</div>
		</div>
		<?php } ?>
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