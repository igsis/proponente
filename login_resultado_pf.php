<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if(isset($_POST['busca']))
{
	$busca = validaCPF($_POST['busca']);
	$sql_busca = "SELECT * FROM usuario_pf WHERE login = '$busca' ORDER BY nome";
	$query_busca = mysqli_query($con,$sql_busca); 
	$num_busca = mysqli_num_rows($query_busca);
	if($busca == false)
	{
		$mensagem = "<font color='red'>CPF inválido! Redirecionando...</font>";
		echo "<script type=\"text/javascript\">window.setTimeout(\"location.href='verifica_pf.php';\", 3600);</script>";		
	}
}

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
?>
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
			<section id="list_items" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h3>USUÁRIO JÁ POSSUI CADASTRO</h3>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<div class="table-responsive list_info">
								<table class="table table-condensed">
									<thead>
										<tr class="list_menu">
											<td>Nome</td>
											<td>CPF</td>
											<td width="15%"></td>
										</tr>
									</thead>
									<tbody>
									<?php
										while($descricao = mysqli_fetch_array($query_busca))
										{			
											echo "
												<tr>
													<td class='list_description'><b>".$descricao['nome']."</b></td>
													<td class='list_description'>".$descricao['login']."</td>
													<td><a href='https://goo.gl/forms/AM7jU1XVDUBUVJXE3'><input type='submit' value='Esqueci a Senha' class='btn btn-theme btn-block'></a></td>
												</tr>
											";
										}
									?>
									</tbody>
								</table>
							</div>
							
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<a href="index.php"><input type="submit" value="Entrar com outro usuário" class="btn btn-theme btn-block"></a> 
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</section>
		</body>
	</html>	

<?php
}
else
{ // se não existir o cpf, imprime um formulário.
	$busca = $_POST['busca'];
?>	
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
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h3>CADASTRO DE PESSOA FÍSICA</h3>				
						<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
						<form class="form-horizontal" role="form" action="login_cadastro_pf.php" method="post">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
									<input type="text" class="form-control" name="nome" placeholder="Nome completo">
								</div>
							</div>
							  
							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Senha: *</strong>
									<input type="password" name="senha01" class="form-control" id="inputName" placeholder="">
								</div>
								<div class=" col-md-6"><strong>Redigite a senha: *</strong>
									<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="">
								</div>
							</div>
							
							<div class="form-group">	
								<div class="col-md-offset-2 col-md-6"><strong>CPF: *</strong><br/>
									<input type="text" readonly class="form-control" name="cpf" value="<?php echo $busca ?>" placeholder="CPF">
								</div>
								<div class="col-md-6"><strong>Email: *</strong><br/>
									<input type="text" class="form-control" name="email" placeholder="Email">
								</div>
							</div>
								  
							<!-- Botão para Gravar -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" value="<?php echo $busca ?>">
									<input type="hidden" name="cadastraNovoPf">
									<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
								</div>
							</div>
						</form>
						
						</div>
					</div>
				</div>
			</section> 
			<?php include "visual/rodape.php" ?>
		</body>
	</html>	
<?php	
}
?>
