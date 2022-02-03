<?php
	SESSION_START();
	include("core/koneksi.php");
	$page=(empty($_GET['page'])?"Tabel Wordlist":$_GET['page']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>ANALISIS SENTIMEN PENGGEMAR KOREAN POP DARI TWITTER</title>

	<!-- Main Styles -->
	<link rel="stylesheet" href="assets/styles/style-horizontal.min.css">

	<!-- Data Tables -->
	<link rel="stylesheet" href="assets/plugin/datatables/media/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugin/datatables/extensions/Responsive/css/responsive.bootstrap.min.css">

	<style type="text/css">
		table tr th{
			text-align: center;
			padding: 10px;
		}
		table tr td{
			padding: 5px;
		}
		.menu a button{
			margin-bottom: 10px;
		}
		.btn-primary{
			background-color: #1B95E0;
		}
		.head{
			margin-top: 0px;
			padding-bottom:10px;
			text-align: center;
		}
	</style>
</head>

<body>
<header class="fixed-header">
	<!-- <div class="header-top" style="background-color: #C1F1FF;height: 100px;padding-top: 10px;">
		<div class="container">
			<div class="pull-left">
				<table border="0">
					<tr>
						<td>
							<img src="images/logo.jpg" width="80px">
						</td>
						<td>
							<a href="#" class="logo" style="color: black;">
								IMPLEMENTASI PENGGUNAAN SEMANTIC SIMILARITY <br>UNTUK MENENTUKAN KEMIRIPAN JAWABAN ESSAY</a>							
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div> -->
	<!-- /.header-top -->
	<nav class="nav-horizontal" style="margin-top:-65px;background-color: #1B95E0;">
		<div class="container">
			
			<ul class="menu" style="text-align: center;">
				<li>
					<h3>ANALISIS SENTIMEN PENGGEMAR KOREAN POP DARI TWITTER</h3>
				</li>
				
			</ul>
			<!-- /.menu -->
		</div>
		<!-- /.container -->
	</nav>
	<nav class="nav-horizontal" style="margin-top: 5px;">
		<div class="container">
			
			<ul class="menu" style="text-align: center;">
				<li>
					<span>FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH JAKARTA</span>
				</li>
				
			</ul>
			<!-- /.menu -->
		</div>
		<!-- /.container -->
	</nav>
	<!-- /.nav-horizontal -->
</header>
<!-- /.fixed-header -->

<div id="wrapper" style="margin-top: -15px;">
	<div class="main-content container">
		<div class="row">
			<div class="col-lg-3">
				<div class="box-content menu">
					<h2 style="text-align: center;margin-top: 0px;">MENU</h2>
					<a href="?page=Tabel Wordlist"><button class="btn btn-<?php echo ($page=="Tabel Wordlist"?"primary":"default"); ?> btn-block" type="button">Tabel Wordlist</button></a>
					<a href="?page=Tabel Tweet"><button class="btn btn-<?php echo ($page=="Tabel Tweet"?"primary":"default"); ?> btn-block" type="button">Tabel Tweet</button></a>
					<a href="?page=Tweet Training"><button class="btn btn-<?php echo ($page=="Tweet Training"?"primary":"default"); ?> btn-block" type="button">Tweet Training</button></a>
					<a href="?page=Tweet Testing"><button class="btn btn-<?php echo ($page=="Tweet Testing"?"primary":"default"); ?> btn-block" type="button">Tweet Testing</button></a>
				</div>
			</div>

			<div class="col-lg-9">
				<?php
					if(in_array($page, $avail_page)){
						include("pages/".$page.".php");
					}else{
						include("pages/404.php");
					}
				?>
			</div>
		</div>
	</div>
	<!-- /.main-content -->
</div><!--/#wrapper -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="assets/script/html5shiv.min.js"></script>
		<script src="assets/script/respond.min.js"></script>
	<![endif]-->
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/scripts/jquery.min.js"></script>
	<script src="assets/scripts/modernizr.min.js"></script>
	<script src="assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<!-- Data Tables -->
	<script src="assets/plugin/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="assets/plugin/datatables/media/js/dataTables.bootstrap.min.js"></script>
	<script src="assets/plugin/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
	<script src="assets/plugin/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
	<script src="assets/scripts/datatables.demo.js"></script>

	<script src="assets/scripts/main.min.js"></script>
	<script src="assets/scripts/horizontal-menu.min.js"></script>
</body>
</html>