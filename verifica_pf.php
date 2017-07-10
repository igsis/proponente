<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Mapeamento e Cadastro de Artistas e Profissionais de Arte e Cultura</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<script src="visual/js/modernizr.custom.js"></script>
	</head>
	<body>	
		<section id="services" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h3>Cadastro de Pessoa Física</h3>
							<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
							<p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
							<p></p>
						</div>
					</div>
				</div>
				<div class="row">
					<form method="POST" action="login_resultado_pf.php" class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">				      
								<label>Insira o CPF</label>
									<input type="text" name="busca" class="form-control" id="cpf" >
							</div>
						</div>
						
						<br />             
					 
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="hidden" value="busca">
								<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<?php include "visual/rodape.php" ?>
	</body>
</html>		