<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Mapeamento e Cadastro de Artistas e Profissionais de Arte e Cultura</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<script src="visual/js/modernizr.custom.js"></script>
		<script src="visual/js/jquery-1.9.1.js"></script>
		<script src="visual/js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="visual/js/jquery.maskMoney.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){	$("#cnpj").mask("99.999.999/9999-99");});
		</script>
	</head>
	<body>	
		<section id="services" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h3>Cadastro de Pessoa Jurídica</h3>
							<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
							<p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
							<p></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form method="POST" action="login_resultado_pj.php" class="form-horizontal" role="form">
								<label>Insira o CNPJ</label>
								<input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj" >
								<br />             
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="hidden" name="pesquisar" value="1" />
										<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>	
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php include "visual/rodape.php" ?>
	</body>
</html>		