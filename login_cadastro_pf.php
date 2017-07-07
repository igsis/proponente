<?php

if(isset($_POST['cadastraNovoPf']))
{		
	//verifica se há um post
	if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) > 5))
	{
		if($_POST['senha01'] == $_POST['senha02'])
		{
			$nome = addslashes($_POST['nome']);
			$email = $_POST['email'];
			$login = $_POST['login'];
			$senha01 = md5($_POST['senha01']);
			$sql_senha = "INSERT INTO `usuario_pf`(nome, email, login, senha) VALUES ('$nome', '$email', '$login', '$senha01')";
			$query_senha = mysqli_query($con,$sql_senha);
			if($query_senha)
			{
				$mensagem = "Usuário cadastrado com sucesso!";	
			}
			else
			{
				$mensagem = "Erro ao cadastrar. Tente novamente.";	
			}
		}
		else
		{
			// caso não tenha digitado 2 vezes
			$mensagem = "As senhas não conferem. Tente novamente.";
		}
	}
	else
	{
		$mensagem = "A senha não pode estar em branco e deve conter mais de 5 caracteres";	
	}
}
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
					<form class="form-horizontal" role="form" action="login_resultado_pf.php" method="post">
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
							<div class="col-md-6"><strong>E-mail: *</strong><br/>
								<input type="text" class="form-control" name="email" placeholder="E-mail">
							</div>
						</div>
							  
						<!-- Botão para Gravar -->
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
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